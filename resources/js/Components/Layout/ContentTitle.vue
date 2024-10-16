<script>
export default {
    name: "ContentTitle",
    props: {
        title: String,
        actionTitle: String,
    }
}
</script>

<template>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ title }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <div class="breadcrumb float-sm-right">
                        <div class="breadcrumb-item">
                            <button type="button" href="#" class="btn btn-block btn-primary">{{ actionTitle }}</button>
                        </div>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
</template>

<style scoped>

</style>
