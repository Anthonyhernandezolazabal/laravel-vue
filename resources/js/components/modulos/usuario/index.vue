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
                            <tr>
                                <td>
                                    <img src="" alt="">
                                </td>
                                <td>Anthony</td>
                                <td>correeo@dominio.com</td>
                                <td>anthony23</td>
                                <td>
                                    <span class="badge badge-success">Activo</span>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" type="button"><i class="fas fa-folder"></i> Ver</button>
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

                            <li  class="page-item">
                                <a href="#" class="page-link">Ant</a>
                            </li>
                            <li  class="page-item activec">
                                <a href="#" class="page-link">1</a>
                            </li>
                            <li class="page-item">
                                <a href="#" class="page-link">Post</a>
                            </li>

                        </ul>
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
                fillBsqUsuario: {
                    cNombre: "",
                    cUsuario: "",
                    cCorreo: "",
                    cEstado: "",
                },
                listaUsuarios: [], //Resultado de la busqueda de los usuarios
                listEstados: [ //Filtros por estado
                    {value: "A", label: "Activo"},
                    {value: "I", label: "Inactivo"}
                ]
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
                this.listaUsuarios  = [];
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
                    console.log("Respuesta :",response)
                })
            }
        },

    }

</script>

<style>

</style>
