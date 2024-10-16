<script>
import LayoutComponent from "./Layout/Layout.vue"
import ContentTitle from "./Layout/ContentTitle.vue"
import DataTable from 'datatables.net-vue3'
import DataTableCore from 'datatables.net-dt'

DataTable.use(DataTableCore)

export default {
    name: "PositionList",
    layout: LayoutComponent,
    components: {
        DataTable, ContentTitle
    },
    props: {
    },

    data() {
        return {
            columns: [
                {data: 'name', title: 'Назва'},
                {data: 'updated_at', title: 'Оновлено'},
                {
                    render: (data, type, row) => {
                        return `<a href="#" class="mr-3"><ion-icon name="create-outline"></ion-icon></a>
<a href="#"><ion-icon name="trash-outline"></ion-icon></a>`
                    }, title: 'Дії'
                }
            ]
        }
    }
}
</script>

<template>
    <ContentTitle title="Посади" action-title="Додати посаду"></ContentTitle>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Список посад</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table p-6 table-bordered table-striped">
                                <DataTable ajax="/positions/get" :columns="columns"
                                           :options="{select:true, serverSide:true}">
                                </DataTable>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</template>

<style scoped>

</style>
