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
        <Link href="/employees" class="brand-link">
            <span class="brand-text">Тестове завдання</span>
        </Link>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">

                    <li class="nav-item menu-open mt-2">
                        <Link href="/employees" class="nav-link"
                              :class="{'active': $page.url === '/employees'}">
                            <p>
                                Працівники
                            </p>
                        </Link>
                    </li>

                    <li class="nav-item menu-open mt-2">
                        <Link href="/positions" class="nav-link"
                              :class="{'active': $page.url === '/positions'}">
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
