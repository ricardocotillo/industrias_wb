import './bootstrap';
import 'vite/modulepreload-polyfill'
import 'nouislider/dist/nouislider.css'
import '../css/app.css'
import '@splidejs/splide/css'
import Splide from '@splidejs/splide'
import htmx from 'htmx.org'
import Alpine from 'alpinejs'
import { initializeApp } from 'firebase/app'
import { getStorage, ref, getDownloadURL } from 'firebase/storage'
import axios from 'axios'
import wNumb from 'wnumb'
import noUiSlider from 'nouislider'

// axios.defaults.xsrfHeaderName = 'X-CSRFTOKEN'
// axios.defaults.xsrfCookieName = 'csrftoken'

const config = {
  apiKey: "AIzaSyBZQp1nuuG3ZJeGSuXdaLGPfOFELXEu5kg",
  authDomain: "wbusch-f8fb7.firebaseapp.com",
  databaseURL: "https://wbusch-f8fb7.firebaseio.com",
  projectId: "wbusch-f8fb7",
  storageBucket: "wbusch-f8fb7.appspot.com",
  messagingSenderId: "491905389064",
}
const app = initializeApp(config)
const storage = getStorage()

window.htmx = htmx
window.Alpine = Alpine
window.noUiSlider = noUiSlider

async function getImage(item) {
  const code = item.dataset.code
  const storageRef = ref(storage, `opt/${code}.jpg`)
  try {
    const url = await getDownloadURL(storageRef)
    return url
  } catch (err) {
    return null
  }
}

document.addEventListener('DOMContentLoaded', function () {
  const heroEl = document.querySelector('.hero-splide')
  if (heroEl) {
    const splide = new Splide(heroEl, {
      type: 'loop',
      pagination: false,
      autoplay: true,
    })
    splide?.mount()
  }
  const slides = document.querySelectorAll('.featured-splide li[data-code]')
  slides.forEach(async s => {
    const url = await getImage(s)
    const img = s.querySelector('img')
    if (url) {
      img.src = url
      img.classList.remove('hidden')
    }
  })

  const featuredEls = document.querySelectorAll('.featured-splide')
  featuredEls.forEach(el => {
    const featuredSplide = new Splide(el, {
      type: 'loop',
      perPage: 4,
      pagination: false,
      gap: '.25rem',
      breakpoints: {
        640: {
          perPage: 1,
        },
        1023: {
          perPage: 2,
        },
        1279: {
          perPage: 3,
        },
      },
    })
    featuredSplide?.mount()
  })
})

function loadMissingImages(target) {
  const items = target.querySelectorAll('[data-code].hidden')
  items.forEach(async item => {
    const url = await getImage(item)
    if (url) {
      item.src = url
      item.classList.remove('hidden')
    }
  })
}

htmx.onLoad(function (target) {
  loadMissingImages(target)
})

Alpine.data('yearData', () => ({
  open: true,
  originalMin: null,
  originalMax: null,
  init() {
    this.originalMin = window.yearMin
    this.originalMax = window.yearMax
    noUiSlider.create(
      this.$refs.range,
      {
        format: wNumb({
          decimals: 0
        }),
        step: 1,
        tooltips: true,
        connect: true,
        range: {
          min: window.yearMin,
          max: window.yearMax,
        },
        start: [window.yearMin, window.yearMax],
      }
    )
    this.$refs.range.noUiSlider.on('end', (values) => {
      const [min, max] = values
      const event = new CustomEvent('filter:year', { detail: { min: Number(min), max: Number(max) } })
      document.dispatchEvent(event)
    })
    document.addEventListener('filter:clear', () => {
      this.$refs.range.noUiSlider.set([this.originalMin, this.originalMax])
    })
  }
}))

Alpine.data('lineData', () => ({
  open: true,
  originalLines: [],
  lines: [],
  selectedLines: [],
  query: '',
  init() {
    this.lines = window.lines
    this.originalLines = window.lines
    document.addEventListener('filter:clear', () => {
      this.selectedLines = []
    })
  },
  dispatch() {
    const event = new CustomEvent('filter:lines', { detail: { lines: this.selectedLines } })
    document.dispatchEvent(event)
  },
}))

Alpine.data('brandData', () => ({
  open: true,
  originalBrands: [],
  brands: [],
  selectedBrands: [],
  query: '',
  years: null,
  models: null,
  init() {
    this.brands = window.brands
    this.originalBrands = window.brands
    document.addEventListener('filter:clear', () => {
      this.selectedBrands = []
      this.brands = this.originalBrands
    })

    document.addEventListener('filter:year', ({ detail: { min, max } }) => {
      this.years = { min, max }
      this.search()
    })
    document.addEventListener('filter:models', async ({ detail: { models } }) => {
      this.models = models
      this.search()
    })
  },
  dispatch() {
    const event = new CustomEvent('filter:brands', { detail: { brands: this.selectedBrands } })
    document.dispatchEvent(event)
  },
  async search() {
    const params = {}
    if (this.query.length > 2) {
      params['nombre__icontains'] = this.query
    }
    if (this.years) {
      params['modelos__modelo_productos__ano__range'] = `${this.years.min},${this.years.max}`
    }
    if (this.models) {
      params['modelos__in'] = this.models.join(',')
    }
    const res = await axios.get('/api/marcas', { params })
    this.brands = res.data.data
  }
}))

Alpine.data('modelData', () => ({
  open: true,
  originalModels: [],
  models: [],
  selectedModels: [],
  query: '',
  years: null,
  brands: null,
  init() {
    this.models = window.models
    this.originalModels = window.models
    document.addEventListener('filter:clear', () => {
      this.selectedModels = []
      this.models = this.originalModels
    })

    document.addEventListener('filter:year', ({ detail: { min, max } }) => {
      this.years = { min, max }
      this.search()
    })
    document.addEventListener('filter:brands', ({ detail: { brands } }) => {
      this.brands = brands
      this.search()
    })
  },
  dispatch() {
    const event = new CustomEvent('filter:models', { detail: { models: this.selectedModels } })
    document.dispatchEvent(event)
  },
  async search() {
    const params = {}
    if (this.query.length > 2) {
      params['nombre__icontains'] = this.query
    }
    if (this.years) {
      params['modelo_productos__ano__range'] = `${this.years.min},${this.years.max}`
    }
    if (this.brands) {
      params['marca__in'] = this.brands.join(',')
    }
    const res = await axios.get('/api/modelos', { params })
    this.models = res.data.data
  },
}))

Alpine.data('fullCartData', () => ({
  cart: null,
  text: '',
  showQuoteForm: false,
  sent: false,
  success: false,
  init() {
    this.$watch('cart', v => {
      this.encodeCart()
    })
    const cartStorage = localStorage.getItem('cart');
    if (cartStorage) {
      this.cart = JSON.parse(cartStorage)
    }
  },
  get total() {
    return Object.values(this.cart).map(item => item.count).reduce((a, v) => a + v)
  },
  get totalFormatted() {
    return `(${this.total} items)`
  },
  get totalItems() {
    const num = Object.keys(this.cart).length
    return `(${num} item${num > 1 ? 's' : ''})`
  },
  async requestQuote(e) {
    const form = e.target
    const formData = new FormData(form)
    formData.set('message', this.text)
    axios.post(form.action, formData)
      .then(response => {
        this.sent = true
        this.success = response.data.success
        form.reset()
        this.cart = null
        localStorage.removeItem('cart')
      })
      .catch(error => {
        this.sent = true
        this.success = false
      })
  },
  encodeCart() {
    if (!this.cart) {
      this.text = ''
      return
    }
    const items = Object.values(this.cart).map((v, i) => {
      return `${v.code} cantidad: ${v.count}`
    }).join(',')
    this.text = items
  },
  increase(code) {
    this.cart[code].count += 1
    const event = new CustomEvent('cart:update', { detail: { code, count: 1, desc: '' } })
    document.dispatchEvent(event)
  },
  decrease(code) {
    this.cart[code].count -= 1
    const event = new CustomEvent('cart:update', { detail: { code, count: -1, desc: '' } })
    document.dispatchEvent(event)
  },
  remove(code) {
    delete this.cart[code]
    const event = new CustomEvent('cart:remove', { detail: { code } })
    document.dispatchEvent(event)
  }
}))

Alpine.data('cart', () => ({
  cart: {},
  init() {
    let cartStorage = localStorage.getItem('cart')
    if (cartStorage) {
      this.cart = JSON.parse(cartStorage)
    }
  },
  get totalItems() {
    const num = Object.keys(this.cart).length
    return num
  },
  update(e) {
    const code = e.detail.code
    const desc = e.detail.desc
    if (!this.cart[code]) {
      this.cart[code] = { code, count: 0, desc, }
    }
    this.cart[code].count += e.detail.count
    const cartStorage = JSON.stringify(this.cart)
    localStorage.setItem('cart', cartStorage)
  },
  remove(e) {
    const code = e.detail.code
    delete this.cart[code]
    const cartStorage = JSON.stringify(this.cart)
    localStorage.setItem('cart', cartStorage)
  },
}))

Alpine.data('product', () => ({
  count: 1,
  addToCart(e) {
    const form = e.target
    const code = form.code.value
    const desc = form.desc.value
    const count = Number(form.count.value)
    const event = new CustomEvent('cart:update', { detail: { code, count: count, desc, } })
    document.dispatchEvent(event)
  }
}))

Alpine.data('products', () => ({
  previous: null,
  next: null,
  count: null,
  pages: null,
  showEnd: false,
  productos: [],
  params: {},
  observer: null,
  target: document.querySelector('body'),
  addToCart(e) {
    const form = e.target
    const code = form.code.value
    const desc = form.desc.value
    const count = Number(form.count.value)
    const event = new CustomEvent('cart:update', { detail: { code, count: count, desc, } })
    document.dispatchEvent(event)
  },
  handleFilter() {
    const event = new CustomEvent('filter:open')
    document.dispatchEvent(event)
    const body = document.querySelector('body')
    body.classList.add('overflow-hidden')
  },
  async reset() {
    const resetStartEvent = new CustomEvent('reset:start')
    const resetEndEvent = new CustomEvent('reset:end')
    document.dispatchEvent(resetStartEvent)
    this.disconnect()
    this.productos = []
    
    // Make sure params are properly serialized
    const params = { ...this.params }
    
    // Debug the actual URL that will be requested
    const url = '/api/productos'
    
    try {
      const res = await axios.get(url, { params })
      this.productos = res.data.data
      this.next = res.data.next_page_url
      this.$nextTick(() => {
        loadMissingImages(this.target)
        this.observe()
        document.dispatchEvent(resetEndEvent)
      })
    } catch (error) {
      console.error('Error fetching products:', error)
      console.log('Error response:', error.response)
    }
  },
  observe() {
    if (!this.$refs.next) return
    const options = {
      root: null,
      threshold: 0.1
    }
    this.observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          if (this.next) {
            axios.get(this.next, { params: this.params })
              .then(res => {
                this.productos.push(...res.data.data)
                this.next = res.data.next_page_url
                loadMissingImages(this.target)
              })
          }
        }
      })
    }, options)
    this.observer.observe(this.$refs.next)
  },
  disconnect() {
    if (this.observer) {
      this.observer.disconnect()
    }
  },
  init() {
    this.params = window.filters
    this.productos = window.products.data
    this.next = window.next_page_url
    this.pages = Math.ceil(this.count / 10)
    this.observe()
    document.addEventListener('filter:year', async e => {
      const { min, max } = e.detail
      this.params['producto_modelos__ano__range'] = `${min},${max}`
      this.reset()
    })
    document.addEventListener('filter:lines', e => {
      const { lines } = e.detail
      this.params['tipo__in'] = lines.join(',')
      this.reset()
    })
    document.addEventListener('filter:brands', e => {
      const { brands } = e.detail
      this.params['producto_modelos__modelo__marca__in'] = brands.join(',')
      this.reset()
    })
    document.addEventListener('filter:models', e => {
      const { models } = e.detail
      this.params['producto_modelos__modelo__in'] = models.join(',')
      this.reset()
    })
  },
  clearFilters() {
    this.params = {}
    this.reset()
    const event = new CustomEvent('filter:clear')
    document.dispatchEvent(event)
  },
}))
Alpine.data('contact', () => ({
  sent: false,
  success: false,
  sendEmail(e) {
    const form = e.target;
    const formData = new FormData(form);
    axios.post(form.action, formData)
      .then(response => {
        this.sent = true;
        this.success = response.data.success;
        form.reset()
      })
      .catch(error => {
        this.sent = true;
        this.success = false;
      })
  }
}))
Alpine.start()

const imgContainers = document.querySelectorAll('.image-container')

imgContainers.forEach(container => {
  const img = container.querySelector('img')
  container.addEventListener('mousemove', (e) => {
    const { left, top, width, height } = container.getBoundingClientRect();
    const x = (e.clientX - left) / width * 100
    const y = (e.clientY - top) / height * 100
    img.style.transformOrigin = `${x}% ${y}%`
    img.style.transform = 'scale(2)'
  })

  container.addEventListener('mouseleave', () => {
    img.style.transform = 'scale(1)'
    img.style.transformOrigin = 'center'
  })
})