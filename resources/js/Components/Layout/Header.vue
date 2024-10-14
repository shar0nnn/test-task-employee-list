<script>
import {Link} from "@inertiajs/vue3";

export default {
    name: "Header",
    components: {
        Link
    },

    computed: {
        currentUserName() {
            return this.$page.props.auth.user.name
        }
    },
}
</script>

<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <div>Активний користувач: {{currentUserName}}</div>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <Link :href="route('logout')">Вихід із системи</Link>
            </li>
        </ul>
    </nav>
</template>

<style scoped>

</style>
