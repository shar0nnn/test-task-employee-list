<script>
import Layout from "../Layout/Layout.vue";
import ContentTitle from "../Layout/ContentTitle.vue";
import {Link} from "@inertiajs/vue3";
import DataTable from 'datatables.net-vue3'
import DataTableCore from 'datatables.net-dt'

DataTable.use(DataTableCore)

export default {
    name: "EmployeeList",
    layout: Layout,
    components: {
        DataTable, ContentTitle, Link,
    },
    props: {
        errors: Object,
    },

    data() {
        return {
            columns: [
                {data: 'photo', orderable: false, title: 'Фото'},
                {data: 'full_name', title: 'Ім\'я'},
                {data: 'position', title: 'Посада'},
                {data: 'hired_at', title: 'Дата працевлаштування'},
                {data: 'phone', title: 'Телефон'},
                {data: 'email', title: 'Email'},
                {data: 'salary', title: 'Зарплата'},
                {data: null, render: '#actions', orderable: false, title: 'Дії'}
            ],
        }
    },

    methods: {},
}
</script>

<template>
    <ContentTitle title="Працівники"></ContentTitle>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Список працівників</h3>

                            <div class="float-right">
                                <Link href="/employees/create" class="btn btn-outline-primary">
                                    Додати працівника
                                </Link>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table p-6 table-bordered table-striped">
                                <DataTable ajax="/employees/get" :columns="columns"
                                           :options="{select:true, serverSide:true}">
                                    <template #actions="props">
                                        <Link class="mr-3 btn btn-default"
                                              :href="`/positions/edit/${props.rowData.id}`">
                                            <ion-icon name="create-outline"></ion-icon>
                                        </Link>

                                        <button class="btn btn-default"
                                                @click="showDeletePositionModal(props.rowData)">
                                            <ion-icon name="trash-outline"></ion-icon>
                                        </button>
                                    </template>
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
