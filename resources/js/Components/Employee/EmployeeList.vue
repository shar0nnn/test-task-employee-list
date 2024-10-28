<script>
import Layout from "../Layout/Layout.vue";
import ContentTitle from "../Layout/ContentTitle.vue";
import {Link} from "@inertiajs/vue3";
import DataTable from 'datatables.net-vue3'
import DataTablesLib from 'datatables.net'
import DataTableCore from 'datatables.net-dt'
import {router} from "@inertiajs/vue3"

DataTable.use(DataTableCore)
DataTable.use(DataTablesLib)

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
                {data: null, render: '#photo', orderable: false, title: 'Фото'},
                {data: 'full_name', title: 'Ім\'я'},
                {data: 'position', name: 'position.name', title: 'Посада'},
                {data: 'hired_at', title: 'Дата працевлаштування'},
                {data: 'phone', title: 'Телефон'},
                {data: 'email', title: 'Email'},
                {data: 'salary', title: 'Зарплата'},
                {data: null, render: '#actions', orderable: false, title: 'Дії', width: '10%'}
            ],

            employeeId: null,
            employeeName: null,
        }
    },

    methods: {
        showDeleteEmployeeModal(data) {
            this.employeeId = data.id
            this.employeeName = data.full_name
            $('#delete-employee-modal').modal('show')
        },

        deleteEmployee() {
            $('#delete-employee-modal').modal('hide')
            router.delete(`/employees/${this.employeeId}`)
            window.location.reload()
        },
    },
}
</script>

<template>
    <div class="modal fade" id="delete-employee-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Видалення працівника</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Ви впевнені, що бажаєте видалити працівника - {{ this.employeeName }}?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Назад</button>
                    <button type="button" @click="deleteEmployee" class="btn btn-primary">Видалити</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

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
                                    <template #photo="props">
                                        <img v-if="props.rowData.photo" class="direct-chat-img"
                                             :src="'/storage/' + props.rowData.photo">
                                    </template>

                                    <template #actions="props">
                                        <Link class="mr-3 btn btn-default"
                                              :href="`/employees/${props.rowData.id}/edit`">
                                            <ion-icon name="create-outline"></ion-icon>
                                        </Link>

                                        <button class="btn btn-default"
                                                @click="showDeleteEmployeeModal(props.rowData)">
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
