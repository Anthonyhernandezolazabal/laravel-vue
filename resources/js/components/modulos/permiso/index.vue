<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Permiso</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>


        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools"><!-- Lado izquierdo -->
                        <template v-if="listRolPermisosByUsuario.includes('permiso.crear')">
                            <router-link class="btn btn-info btn-sm" :to="{name: 'permiso.crear'}">
                                <i class="fas fa-plus-square"></i> Nuevo Permiso
                            </router-link>
                        </template>
                    </div>
                </div>

                <div class="card-body">
                    <div class="container-fluid">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Criterios de Búsqueda</h3>
                            </div>
                            <div class="card-body">
                                <form role="form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Nombre</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" @keyup.enter="getListarPermisos" v-model="fillBsqPermiso.cNombre">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Url Amigabke</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" @keyup.enter="getListarPermisos" v-model="fillBsqPermiso.cSlug">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-4 offset-4">
                            <button class="btn btn-float btn-info btnwidth" @click.prevent="getListarPermisos" v-loading.fullscreen.lock="fullscreenLoading">Buscar</button>
                            <button class="btn btn-float btn-default btnwidth" @click.prevent="limpiarCriteriosBsq">Limpiar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        Bandeja de Resultados
                    </h3>
                </div>

                <div class="card-body table-responsive">
                    <template v-if="listarPermisosPaginated.length">
                        <table class="table table-hover table-head-fixed text-nowrap projects">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Url Amigable</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in listarPermisosPaginated" :key="index">
                                    <td v-text="item.name"></td>
                                    <td v-text="item.slug"></td>
                                    <td>
                                        <template v-if="listRolPermisosByUsuario.includes('permiso.editar')">
                                            <router-link class="btn btn-flat btn-info btn-sm" :to="{name:'permiso.editar', params:{id: item.id}}">
                                                <i class="fas fa-pencil-alt"></i> Editar
                                            </router-link>
                                        </template>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">

                                <li  class="page-item" v-if="pageNumber > 0">
                                    <a href="#" class="page-link" @click.prevent="prevPage">Ant</a>
                                </li>
                                <li  class="page-item" v-for="(page, index) in pagesList" :key="index" :class="[page == pageNumber ? 'active' : '']">
                                    <a href="#" class="page-link" @click.prevent="selectPage(page)"> {{page+1}} </a>
                                </li>
                                <li class="page-item" v-if="pageNumber < pageCount - 1">
                                    <a href="#" class="page-link" @click.prevent="nextPage">Post</a>
                                </li>

                            </ul>
                        </div>
                    </template>

                    <template v-else>
                        <div class="callout callout-info">
                            <h5>No se encontraron resultados...</h5>
                        </div>
                    </template>
                </div>

            </div>
        </div>






    </div>
</template>

<script>
import axios from 'axios';
    export default {
        data(){
            return{
                fillBsqPermiso: {
                    cNombre: "",
                    cSlug: "",
                },
                listPermisos: [],
                listRolPermisosByUsuario: JSON.parse(sessionStorage.getItem('listRolPermisosByUsuario')),
                fullscreenLoading:false,
                pageNumber: 0, //Número de la página paginada
                perPage: 5

            }
        },
        computed: {
            // Obtener el número de página
            pageCount(){
                let a = this.listPermisos.length,// 20
                    b = this.perPage;//5
                return Math.ceil(a / b);// 20/5 = 4
            },
            // Obtener registros paginados
            listarPermisosPaginated(){
                //inicio:            0       *       5       = 0
                //fin: 0 + 5
                //0 - (5-1)
                let inicio = this.pageNumber * this.perPage,
                    fin = inicio + this.perPage;
                return this.listPermisos.slice(inicio,fin);
            },
            pagesList(){
                let a = this.listPermisos.length,
                    b = this.perPage;
                let pageCount = Math.ceil(a / b);
                let count = 0,
                    pagesArray = [];
                while (count < pageCount) {
                    pagesArray.push(count);
                    count++;
                }
                return pagesArray;
            }
        },
        methods: {

            limpiarCriteriosBsq(){
                this.fillBsqPermiso.cNombre     = "";
                this.fillBsqPermiso.cSlug    = "";
            },


            getListarPermisos(){
                this.fullscreenLoading = true;
                var url = "/administracion/permiso/getListarPermisos"
                axios.get(url,{
                    params: {
                        "cNombre"   :   this.fillBsqPermiso.cNombre,
                        "cSlug"   :   this.fillBsqPermiso.cSlug,
                    }
                }).then(response => {
                    console.log("response  lista:",response)
                    this.inicializarPaginacion();
                    this.listPermisos =response.data
                    this.fullscreenLoading = false;

                }).catch(error => {
                    if (error.response.status == 401) {
                        this.$router.push({name: 'login'})
                        location.reload();
                        sessionStorage.clear();
                        this.fullscreenLoading = false;
                    }
                })
            },
            nextPage() {
                this.pageNumber++;
            },
            prevPage() {
                this.pageNumber--;
            },
            selectPage(page){
                this.pageNumber = page;
            },
            inicializarPaginacion(){
                this.pageNumber = 0;
            },

        },

    }

</script>

<style>

</style>
