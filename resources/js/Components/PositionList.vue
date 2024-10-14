<script>
import LayoutComponent from "./Layout/Layout.vue";
import MainContentTitleComponent from "./Layout/ContentTitle.vue";

export default {
    name: "PositionListComponent",
    components: {MainContentTitleComponent},
    layout: LayoutComponent,
}
</script>

<template>
    <MainContentTitleComponent title="Position List"></MainContentTitleComponent>
    <div>Position List</div>
</template>

<style scoped>

</style>
