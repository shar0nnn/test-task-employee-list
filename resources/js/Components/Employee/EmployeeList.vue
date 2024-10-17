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
    //     resource: Array,
    },

    data() {
        return {
            columns: [
                {data: 'photo', title: 'Фото'},
                {data: 'full_name', title: 'Ім\'я'},
                {data: 'position', title: 'Посада'},
                {data: 'hired_at', title: 'Дата початку роботи'},
                {data: 'phone', title: 'Телефон'},
                {data: 'email', title: 'Email'},
                {data: 'salary', title: 'Зарплата'},
                {render: (data, type, row) => {
                    return `<a href="#" class="mr-3"><ion-icon name="create-outline"></ion-icon></a>
<a href="#"><ion-icon name="trash-outline"></ion-icon></a>`
                    }, title: 'Дії'}
            ],

            employees: null,
        }
    },

    mounted() {
        // this.getEmployees()
    },

    methods: {
        getEmployees() {
            axios.get('/employees/get')
                .then(result => {
                    console.log(result);
                    this.employees = result.data.data
                    setTimeout(() => {
                        new DataTable('#employees-table')
                    }, 10)
                })
        }
    },
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
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="employees-table" class="table p-6 table-bordered table-striped">
                                <DataTable ajax="/employees/get" :columns="columns"
                                           :options="{select:true, serverSide:true}">
                                </DataTable>
                                <!--                                <thead>-->
                                <!--                                <tr>-->
                                <!--                                    <th>Фото</th>-->
                                <!--                                    <th>Ім'я</th>-->
                                <!--                                    <th>Посада</th>-->
                                <!--                                    <th>Дата початку роботи</th>-->
                                <!--                                    <th>Телефон</th>-->
                                <!--                                    <th>Email</th>-->
                                <!--                                    <th>Зарплата</th>-->
                                <!--                                    <th>Дії</th>-->
                                <!--                                </tr>-->
                                <!--                                </thead>-->

                                <!--                                <tbody>-->
                                <!--                                <tr v-for="employee in employees">-->
                                <!--                                    <td>{{ employee.photo }}</td>-->
                                <!--                                    <td>{{ employee.full_name }}</td>-->
                                <!--                                    <td>{{ employee.position }}</td>-->
                                <!--                                    <td>{{ employee.hired_at }}</td>-->
                                <!--                                    <td>{{ employee.phone }}</td>-->
                                <!--                                    <td>{{ employee.email }}</td>-->
                                <!--                                    <td>{{ employee.salary }}</td>-->
                                <!--                                    <td>-->
                                <!--                                        <Link href="#" class="mr-3">-->
                                <!--                                            <ion-icon name="create-outline"></ion-icon>-->
                                <!--                                        </Link>-->
                                <!--                                        <Link href="#">-->
                                <!--                                            <ion-icon name="trash-outline"></ion-icon>-->
                                <!--                                        </Link>-->
                                <!--                                    </td>-->
                                <!--                                </tr>-->
                                <!--                                </tbody>-->
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
