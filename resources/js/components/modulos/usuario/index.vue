<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Usuarios</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Usuarios v1</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>


        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools"><!-- Lado izquierdo -->
                        <template v-if="listRolPermisosByUsuario.includes('usuario.crear')">
                            <router-link class="btn btn-info btn-sm" :to="{name: 'usuario.crear'}">
                                <i class="fas fa-plus-square"></i> Nuevo Usuario
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
                                                    <input type="text" class="form-control" @keyup.enter="getListaUsuarios" v-model="fillBsqUsuario.cNombre">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Usuario</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" @keyup.enter="getListaUsuarios" v-model="fillBsqUsuario.cUsuario">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Correo Electrónico</label>
                                                <div class="col-md-9">
                                                    <input type="email" class="form-control" @keyup.enter="getListaUsuarios" v-model="fillBsqUsuario.cCorreo">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Estado</label>
                                                <div class="col-md-9">
                                                    <el-select @keyup.enter="getListaUsuarios" v-model="fillBsqUsuario.cEstado" placeholder="Selecciona un estado" clearable>
                                                        <el-option
                                                        v-for="item in listEstados"
                                                        :key="item.value"
                                                        :label="item.label"
                                                        :value="item.value">
                                                        </el-option>
                                                    </el-select>
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
                            <button class="btn btn-float btn-info btnwidth" @click.prevent="getListaUsuarios" v-loading.fullscreen.lock="fullscreenLoading">Buscar</button>
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
                    <template v-if="listarUsuariosPaginated.length">
                        <table class="table table-hover table-head-fixed text-nowrap projects">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Usuarioo</th>
                                    <th>Estado</th>
                                    <th>Accioness</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in listarUsuariosPaginated" :key="index">
                                    <td>
                                        <template v-if="!item.profile_image">
                                            <li class="user-block">
                                                <img src="/img/avatar.png" :alt="item.username" class="profile-avatar-img img-fluid img-circle">
                                            </li>
                                        </template>
                                        <template v-else>
                                            <li class="user-block">
                                                <img :src="item.profile_image" :alt="item.username" class="profile-avatar-img img-fluid img-circle">
                                            </li>
                                        </template>
                                    </td>
                                    <td v-text="item.fullname"></td>
                                    <td v-text="item.email"></td>
                                    <td v-text="item.username"></td>
                                    <td>
                                        <template v-if="item.state == 'A'">
                                            <span class="badge badge-success">Activo</span>
                                        </template>
                                        <template v-if="item.state == 'I'">
                                            <span class="badge badge-danger">Inactivo</span>
                                        </template>
                                    </td>
                                    <td>
                                        <template v-if="listRolPermisosByUsuario.includes('usuario.ver')">
                                            <router-link class="btn btn-flat btn-primary btn-sm" :to="{name:'usuario.ver', params:{id: item.id}}">
                                                <i class="fas fa-folder"></i> Ver
                                            </router-link>
                                        </template>
                                        <template v-if="item.state == 'A'">
                                            <template v-if="listRolPermisosByUsuario.includes('usuario.editar')">
                                                <router-link class="btn btn-flat btn-info btn-sm" :to="{name:'usuario.editar', params:{id: item.id}}">
                                                    <i class="fas fa-pencil-alt"></i> Editar
                                                </router-link>
                                            </template>
                                            <template v-if="listRolPermisosByUsuario.includes('usuario.permiso')">
                                                <router-link class="btn btn-flat btn-success btn-sm" :to="{name:'usuario.permiso', params:{id: item.id}}">
                                                    <i class="fas fa-key"></i> Permiso
                                                </router-link>
                                            </template>
                                            <template v-if="listRolPermisosByUsuario.includes('usuario.desactivar')">
                                                <button class="btn btn-flat btn-danger btn-sm" @click.prevent="setCambiarEstadoUsuario(1, item.id)">
                                                    <i class="fas fa-trash"></i> Desactivar
                                                </button>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <template v-if="listRolPermisosByUsuario.includes('usuario.activar')">
                                                <button class="btn btn-flat btn-danger btn-sm" @click.prevent="setCambiarEstadoUsuario(2, item.id)">
                                                    <i class="fas fa-check"></i> Activar
                                                </button>
                                            </template>
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
                fillBsqUsuario: {
                    cNombre: "",
                    cUsuario: "",
                    cCorreo: "",
                    cEstado: "",
                },
                listUsuarios: [], //Resultado de la busqueda de los usuarios
                listEstados: [ //Filtros por estado
                    {value: "A", label: "Activo"},
                    {value: "I", label: "Inactivo"}
                ],
                listRolPermisosByUsuario: JSON.parse(sessionStorage.getItem('listRolPermisosByUsuario')),
                fullscreenLoading:false,
                pageNumber: 0, //Número de la página paginada
                perPage: 5, //Número de registros a mostrar por paginación
            }
        },
        computed: {
            // Obtener el número de página
            pageCount(){
                let a = this.listUsuarios.length,// 20
                    b = this.perPage;//5
                return Math.ceil(a / b);// 20/5 = 4
            },
            // Obtener registros paginados
            listarUsuariosPaginated(){
                //inicio:            0       *       5       = 0
                //fin: 0 + 5
                //0 - (5-1)
                let inicio = this.pageNumber * this.perPage,
                    fin = inicio + this.perPage;
                return this.listUsuarios.slice(inicio,fin);
            },
            pagesList(){
                let a = this.listUsuarios.length,
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
                this.fillBsqUsuario.cNombre     = "";
                this.fillBsqUsuario.cUsuario    = "";
                this.fillBsqUsuario.cCorreo     = "";
                this.fillBsqUsuario.cEstado     = "";
            },
            limpiarBandejaUsuarios(){
                this.listUsuarios  = [];
            },
            getListaUsuarios(){
                this.fullscreenLoading = true;
                var url = "/administracion/usuarios/getListaUsuarios"
                axios.get(url,{
                    params: {
                        "cNombre"       :   this.fillBsqUsuario.cNombre,
                        "cUsuario"      :   this.fillBsqUsuario.cUsuario,
                        "cCorreo"       :   this.fillBsqUsuario.cCorreo,
                        "cEstado"       :   this.fillBsqUsuario.cEstado,
                    }
                }).then(response => {
                    this.inicializarPaginacion();
                    this.listUsuarios =response.data
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
            setCambiarEstadoUsuario(op, id){
                Swal.fire({
                    title: 'Estás seguro de '+ ((op == 1) ? "desactivar" : "activar") + "el usuario ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: ((op == 1) ? "Si, desactivar" : "Si, activar")
                    }).then((result) => {
                    if (result.isConfirmed) {
                        // Aquí ira la confirmación del boton, es decir la petición al servidor
                        this.fullscreenLoading = true;
                        var url = '/administracion/usuario/setCambiarEstadoUsuario'
                        axios.post(url, {
                            'nIdUsuario' : id,
                            'cEstado'    : (op == 1) ? 'I' : 'A'
                        }).then(response => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Usuario '+ (op==1) ? "inactivo" : "activo",
                                showConfirmButton: false,
                                timer: 1500
                            })
                            this.getListaUsuarios();
                        }).catch(error => {
                            if (error.response.status == 401) {
                                this.$router.push({name: 'login'})
                                location.reload();
                                sessionStorage.clear();
                                this.fullscreenLoading = false;
                            }
                        })
                    }
                })
            }
        },

    }

</script>

<style>

</style>
