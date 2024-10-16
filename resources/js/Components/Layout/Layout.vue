<script>
import Footer from "./Footer.vue";
import Sidebar from "./Sidebar.vue";
import Header from "./Header.vue";

export default {
    name: "Layout",
    components: {
        Sidebar, Header, Footer
    }
}
</script>

<template>
    <div class="wrapper">

        <!-- Header -->
        <Header></Header>
        <!-- /.header -->

        <!-- Main Sidebar Container -->
        <Sidebar></Sidebar>
        <!-- /.main-sidebar-container -->

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

        <!-- Footer -->
        <Footer></Footer>
        <!-- /.footer -->
    </div>
</template>

<style scoped>

</style>
