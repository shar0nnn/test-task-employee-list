<script>
import LayoutComponent from "./Layout/Layout.vue";
import ContentTitle from "./Layout/ContentTitle.vue";

export default {
    name: "EmployeeList",
    layout: LayoutComponent,
    components: {
        ContentTitle
    },
}
</script>

<template>
    <ContentTitle title="Employee List"></ContentTitle>

    <div>Employee List</div>
</template>

<style scoped>

</style>
