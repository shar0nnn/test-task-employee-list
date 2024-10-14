<script>
import FooterComponent from "./Footer.vue";
import SidebarMenuComponent from "./Sidebar.vue";
import HeaderComponent from "./Header.vue";

export default {
    name: "Layout",
    components: {HeaderComponent, SidebarMenuComponent, FooterComponent}
}
</script>

<template>
    <div class="wrapper">

        <!-- Navbar -->
        <HeaderComponent></HeaderComponent>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <SidebarMenuComponent></SidebarMenuComponent>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <slot/>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <FooterComponent></FooterComponent>

    </div>
</template>

<style scoped>

</style>
