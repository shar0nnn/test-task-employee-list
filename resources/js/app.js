import './bootstrap'
import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3'
import {ZiggyVue} from 'ziggy-js'
import {Ziggy} from "./ziggy.js"
// import DataTable from 'datatables.net-vue3'
// import DataTableCore from 'datatables.net-dt'
//
// DataTable.use(DataTableCore)

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Components/**/*.vue', {eager: true})
        return pages[`./Components/${name}.vue`]
    },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            // .component('DataTable', DataTable)
            .mount(el)
    },
})
