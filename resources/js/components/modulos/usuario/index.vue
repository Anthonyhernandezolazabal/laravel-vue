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
                        <router-link :to="'/'" class="btn btn-info btn-sm">
                            <i class="fas fa-plus-square"></i> Nuevo Usuario
                        </router-link>
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
                                                    <input type="text" class="form-control" v-model="fillBsqUsuario.cNombre">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Usuario</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" v-model="fillBsqUsuario.cUsuario">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Correo Electrónico</label>
                                                <div class="col-md-9">
                                                    <input type="email" class="form-control" v-model="fillBsqUsuario.cCorreo">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Estado</label>
                                                <div class="col-md-9">
                                                    <el-select v-model="fillBsqUsuario.cEstado" placeholder="Selecciona un estado" clearable>
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
                            <button class="btn btn-float btn-info btnwidth" @click.prevent="getListaUsuarios">Buscar</button>
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
                                        <li class="user-block">
                                            <img src="/img/avatar.png" :alt="item.username" class="profile-avatar-img img-fluid img-circle">
                                        </li>
                                    </td>
                                    <td v-text="item.fullname">Anthony</td>
                                    <td v-text="item.email">Anthony</td>
                                    <td v-text="item.username">Anthony</td>
                                    <td>
                                        <template v-if="item.state == 'A'">
                                            <span class="badge badge-success">Activo</span>
                                        </template>
                                        <template v-if="item.state == 'I'">
                                            <span class="badge badge-danger">Inactivo</span>
                                        </template>
                                    </td>
                                    <td>
                                        <router-link  class="btn btn-primary btn-sm" type="button" :to="'/'"><i class="fas fa-folder"></i> Ver</router-link>
                                        <button class="btn btn-info btn-sm" type="button"><i class="fas fa-pencil-alt"></i> Editar</button>
                                        <button class="btn btn-success btn-sm" type="button"><i class="fas fa-key"></i> Permmiso</button>
                                        <button class="btn btn-danger btn-sm" type="button"><i class="fas fa-trash"></i> Desactivar</button>
                                        <button class="btn btn-success btn-sm" type="button"><i class="fas fa-check"></i> Activar</button>
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

                    <template>
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
                var url = "/administracion/usuarios/getListaUsuarios"
                axios.get(url,{
                    params: {
                        "cNombre"   :   this.fillBsqUsuario.cNombre,
                        "cUsuario"   :   this.fillBsqUsuario.cUsuario,
                        "cCorreo"   :   this.fillBsqUsuario.cCorreo,
                        "cEstado"   :   this.fillBsqUsuario.cEstado,
                    }
                }).then(response => {
                    console.log("Respuesta :",response.data)
                    this.listUsuarios =response.data

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
            }
        },

    }

</script>

<style>

</style>
