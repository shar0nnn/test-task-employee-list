<script>
import {Link} from "@inertiajs/vue3"

export default {
    name: "Sidebar",
    components: {
        Link,
    }
}
</script>

<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <Link :href="route('employees.index')" class="brand-link">
            <span class="brand-text">Тестове завдання</span>
        </Link>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">

                    <li class="nav-item menu-open mt-2">
                        <Link :href="route('employees.index')" class="nav-link"
                              :class="{'active': $page.url === '/employees/list'}">
                            <p>
                                Співробітники
                            </p>
                        </Link>
                    </li>

                    <li class="nav-item menu-open mt-2">
                        <Link :href="route('positions.index')" class="nav-link"
                              :class="{'active': $page.url === '/positions/list'}">
                            <p>
                                Посади
                            </p>
                        </Link>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<style scoped>

</style>
