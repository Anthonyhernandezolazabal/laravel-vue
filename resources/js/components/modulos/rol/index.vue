<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Rol</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>


        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools"><!-- Lado izquierdo -->
                        <template v-if="listRolPermisosByUsuario.includes('rol.crear')">
                            <router-link class="btn btn-info btn-sm" :to="{name: 'rol.crear'}">
                                <i class="fas fa-plus-square"></i> Nuevo Rol
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
                                                    <input type="text" class="form-control" @keyup.enter="getListarRoles" v-model="fillBsqRol.cNombre">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Url Amigabke</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" @keyup.enter="getListarRoles" v-model="fillBsqRol.cSlug">
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
                            <button class="btn btn-float btn-info btnwidth" @click.prevent="getListarRoles" v-loading.fullscreen.lock="fullscreenLoading">Buscar</button>
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
                    <template v-if="listarRolesPaginated.length">
                        <table class="table table-hover table-head-fixed text-nowrap projects">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Url Amigable</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in listarRolesPaginated" :key="index">
                                    <td v-text="item.name"></td>
                                    <td v-text="item.slug"></td>
                                    <td>
                                        <template v-if="listRolPermisosByUsuario.includes('rol.ver')">
                                            <button class="btn btn-flat btn-primary btn-sm" @click.prevent="abrirModalByOption('rol', 'ver', item)">
                                                <i class="fas fa-folder"></i> Ver
                                            </button>
                                        </template>
                                        <template v-if="listRolPermisosByUsuario.includes('rol.editar')">
                                            <router-link class="btn btn-flat btn-info btn-sm" :to="{name:'rol.editar', params:{id: item.id}}">
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




        <div class="modal fade" :class="{ show: modalShow }" :style=" modalShow ? mostrarModal : ocultarModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Sistema Laravel y Vue</h5>
                        <button class="close" @click="abrirModal"></button>
                    </div>
                    <div class="modal-body">
                        <template v-if="modalOption == 1">
                            <div class="callout callout-danger" style="padding: 5px" v-for="(item, index) in mensajeError" :key="index" v-text="item"></div>
                        </template>
                        <template v-if="modalOption == 2">
                            <div class="container-fluid">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Información del Rol</h3>
                                    </div>
                                    <div class="card-body">
                                        <form role="form">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="col-md-12 col-form-label">Nombre</label>
                                                        <div class="col-md-12">
                                                            <span class="form-control" v-text="fillVerRol.cNombre"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="col-md-12 col-form-label">Url Amigable</label>
                                                        <div class="col-md-12">
                                                            <span class="form-control" v-text="fillVerRol.cSlug"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Listado de Permisos</h3>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <template v-if="listPermisos.length">
                                            <div class="scrollTable">
                                                <table class="table table-hover table-head-fixed text-nowrap projects">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Url Amigable</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in listPermisos" :key="index">
                                                            <template v-if="item.checked == 1">
                                                                <td v-text="item.name"></td>
                                                                <td v-text="item.slug"></td>
                                                            </template>
                                                        </tr>
                                                    </tbody>
                                                </table>
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
                        </template>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" @click="abrirModal">Cerrar</button>
                    </div>
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
                fillBsqRol: {
                    cNombre: "",
                    cSlug: "",
                },
                fillVerRol: {
                    cNombre : '',
                    cSlug: ''
                },
                listRoles: [], //Resultado de la busqueda de los usuarios
                listPermisos: [],
                fullscreenLoading:false,
                listRolPermisosByUsuario: JSON.parse(sessionStorage.getItem('listRolPermisosByUsuario')),
                pageNumber: 0, //Número de la página paginada
                perPage: 5, //Número de registros a mostrar por paginación
                modalShow: false,
                fullscreenLoading: false,
                mostrarModal: {
                    display: 'block',
                    background: '#0000006b',
                },
                ocultarModal: {
                    display: 'none',
                },
                error: 0,
                modalOption: 0,
                mensajeError: []
            }
        },
        computed: {
            // Obtener el número de página
            pageCount(){
                let a = this.listRoles.length,// 20
                    b = this.perPage;//5
                return Math.ceil(a / b);// 20/5 = 4
            },
            // Obtener registros paginados
            listarRolesPaginated(){
                //inicio:            0       *       5       = 0
                //fin: 0 + 5
                //0 - (5-1)
                let inicio = this.pageNumber * this.perPage,
                    fin = inicio + this.perPage;
                return this.listRoles.slice(inicio,fin);
            },
            pagesList(){
                let a = this.listRoles.length,
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
            abrirModal(){
              this.modalShow = !this.modalShow;
              this.limpiarModal()
            },
            limpiarCriteriosBsq(){
                this.fillBsqRol.cNombre     = "";
                this.fillBsqRol.cSlug    = "";
            },
            limpiarBandejaUsuarios(){
                this.listRoles  = [];
            },
            limpiarModal(){
                this.fillVerRol.cNombre =   ''
                this.fillVerRol.cSlug   =   ''
                this.listPermisos       =   [];
                this.modalOption        =   0;
            },
            getListarRoles(){
                this.fullscreenLoading = true;
                var url = "/administracion/rol/getListarRoles"
                axios.get(url,{
                    params: {
                        "cNombre"   :   this.fillBsqRol.cNombre,
                        "cSlug"   :   this.fillBsqRol.cSlug,
                    }
                }).then(response => {
                    console.log("response  lista:",response)
                    this.inicializarPaginacion();
                    this.listRoles =response.data
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
            getListarPermisosByRol(id){
                console.log("OBTENGO ID: ",id)
                var ruta = '/administracion/rol/getListarPermisosByRol'
                axios.get(ruta, {
                    params: {
                        'nIdRol'   :   id
                    }
                }).then( response => {
                    console.log("VIEW ;",response)
                    this.listPermisos = response.data;
                    this.modalShow      =   true;
                    this.modalOption    =   2;
                }).catch(error => {
                    if (error.response.status == 401) {
                        this.$router.push({name: 'login'})
                        location.reload();
                        sessionStorage.clear();
                        this.fullscreenLoading = false;
                    }
                })
            },
            abrirModalByOption(modulo, accion, data){
                switch (modulo) {
                    case "rol":
                    {
                        switch (accion) {
                            case "ver":
                            {
                                //Setear información del arreglo
                                this.fillVerRol.cNombre =   data.name;
                                this.fillVerRol.cSlug    =   data.slug;
                                //Obtener los permisos por el rol seleccionado
                                this.getListarPermisosByRol(data.id);
                            }
                            break;

                            default:
                                break;
                        }
                    }
                    break;

                    default:
                        break;
                }
            }
        },

    }

</script>

<style>

</style>
