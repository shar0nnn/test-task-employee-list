<script>
import LayoutComponent from "./Layout/Layout.vue";
import MainContentTitleComponent from "./Layout/ContentTitle.vue";

export default {
    name: "EmployeeListComponent",
    components: {MainContentTitleComponent},
    layout: LayoutComponent,
}
</script>

<template>
    <MainContentTitleComponent title="Employee List"></MainContentTitleComponent>
    <div>Employee List</div>
</template>

<style scoped>

</style>
