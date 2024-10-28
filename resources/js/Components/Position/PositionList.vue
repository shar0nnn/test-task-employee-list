<script>
import Layout from "../Layout/Layout.vue"
import ContentTitle from "../Layout/ContentTitle.vue"
import DataTable from 'datatables.net-vue3'
import DataTableCore from 'datatables.net-dt'
import {Link} from "@inertiajs/vue3";

DataTable.use(DataTableCore)

export default {
    name: "PositionList",
    layout: Layout,
    components: {
        Link, DataTable, ContentTitle
    },
    props: {
        errors: Object,
    },

    data() {
        return {
            columns: [
                {data: 'name', title: 'Назва', width: '80%'},
                {data: 'updated_at', title: 'Оновлено'},
                {data: null, render: '#actions', orderable: false, title: 'Дії', width: '10%'}
            ],

            positionIdToDelete: null,
            positionNameToDelete: null,
        }
    },

    methods: {
        showDeletePositionModal(data) {
            this.positionIdToDelete = data.id
            this.positionNameToDelete = data.name
            $('#delete-position-modal').modal('show')
        },

        deletePosition() {
            axios.delete(`/positions/${this.positionIdToDelete}`).then(
                result => {
                    console.log(result);
                    window.location.href = '/positions'
                }
            ).catch(error => {
                console.log(error);
            })
        },
    },
}
</script>

<template>
    <div class="modal fade" id="delete-position-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Видалення посади</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Ви впевнені, що бажаєте видалити посаду - {{ this.positionNameToDelete }}?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Назад</button>
                    <button type="button" @click="deletePosition" class="btn btn-primary">Видалити</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <ContentTitle title="Посади"/>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Список посад</h3>

                            <div class="float-right">
                                <Link href="/positions/create" class="btn btn-outline-primary">
                                    Додати посаду
                                </Link>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table p-6 table-bordered table-striped">
                                <DataTable ajax="/positions/get" :columns="columns"
                                           :options="{select:true, serverSide:true}">
                                    <template #actions="props">
                                        <Link class="mr-3 btn btn-default"
                                              :href="`/positions/${props.rowData.id}/edit`">
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
