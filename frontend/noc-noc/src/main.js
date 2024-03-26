import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './index.css'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faTrash, faTimes, faChevronDown, faChevronRight } from '@fortawesome/free-solid-svg-icons'

library.add(faTrash, faTimes, faChevronDown, faChevronRight)
const app = createApp(App).component('font-awesome-icon', FontAwesomeIcon)

app.use(router)

app.mount('#app')
