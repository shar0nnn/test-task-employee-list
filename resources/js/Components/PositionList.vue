<script>
import LayoutComponent from "./Layout/Layout.vue";
import ContentTitle from "./Layout/ContentTitle.vue";

export default {
    name: "PositionList",
    layout: LayoutComponent,
    components: {
        ContentTitle
    },
}
</script>

<template>
    <ContentTitle title="Position List"></ContentTitle>

    <div>Position List</div>
</template>

<style scoped>

</style>
