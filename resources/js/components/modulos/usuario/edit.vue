<template>

  <div>
    <!-- <h3> {{$route.params.id}}</h3> -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Editar Usuario</h1>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <router-link class="btn btn-info btn-sm" :to="'/usuario'">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </router-link>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Formulario Editar Usuario</h3>
                            </div>
                            <div class="card-body">
                                <form role="form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Primer Nombre</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" v-model="fillEditarUsuario.cPrimerNombre" @keyup.enter="setEditarUsuario">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Segundo Nombre</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" v-model="fillEditarUsuario.cSegundoNombre" @keyup.enter="setEditarUsuario">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Apellidos</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" v-model="fillEditarUsuario.cApellido" @keyup.enter="setEditarUsuario">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Usuario</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" v-model="fillEditarUsuario.cUsuario" @keyup.enter="setEditarUsuario">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Correo Electronico</label>
                                                <div class="col-md-9">
                                                    <input type="email" class="form-control" v-model="fillEditarUsuario.cCorreo" @keyup.enter="setEditarUsuario">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Contraseña</label>
                                                <div class="col-md-9">
                                                    <el-input placeholder="Ingrese una contraseña" v-model="fillEditarUsuario.cContrasena" @keyup.enter="setEditarUsuario" show-password></el-input>
                                                    <!-- <input type="password" class="form-control" v-model="fillEditarUsuario.cContrasena" @keyup.enter="setEditarUsuario"> -->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Rol</label>
                                                <div class="col-md-9">
                                                    <el-select @keyup.enter="getListaUsuarios" v-model="fillEditarUsuario.nIdRol" placeholder="Selecciona un rol" clearable>
                                                        <el-option
                                                        v-for="item in listRoles"
                                                        :key="item.id"
                                                        :label="item.name"
                                                        :value="item.id">
                                                        </el-option>
                                                    </el-select>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Fotografia</label>
                                                <div class="col-md-9">
                                                    <input type="file" class="form-control" @change="getFile">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-4 offset-4">
                                        <button class="btn btn-flat btn-info btnWidth" @click.prevent="setEditarUsuario" v-loading.fullscreen.lock="fullscreenLoading">Editar</button>
                                        <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarCriteriosBsq">Limpiar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                        <div class="callout callout-danger" style="padding: 5px" v-for="(item, index) in mensajeError" :key="index" v-text="item"></div>
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

export default {
    data(){
        return{
            fillEditarUsuario: {
                nIdUsuario: this.$route.params.id,
                cPrimerNombre: "",
                cSegundoNombre: "",
                cUsuario: "",
                cCorreo: "",
                cApellido: "",
                cContrasena: '',
                oFotografia: '',
                nIdRol: ''
            },
            listRoles: [],
            modalShow: false,
            form : new FormData,
            fullscreenLoading: false,
            mostrarModal: {
                display: 'block',
                background: '#0000006b',
            },
            ocultarModal: {
                display: 'none',
            },
            error: 0,
            mensajeError: []
        }
    },
    mounted() {
        this.getUsuarioById();
        this.getListarRoles();
    },
    methods: {
        getUsuarioById(){
            this.fullscreenLoading = true;
            var url = "/administracion/usuarios/getListaUsuarios"
            axios.get(url,{
                params: {
                    "nIdUsuario"   :   this.fillEditarUsuario.nIdUsuario,
                }
            }).then(response => {
                this.fillEditarUsuario.cPrimerNombre    =   response.data[0].firstname;
                this.fillEditarUsuario.cSegundoNombre   =   response.data[0].secondname;
                this.fillEditarUsuario.cApellido        =   response.data[0].lastname;
                this.fillEditarUsuario.cUsuario         =   response.data[0].username;
                this.fillEditarUsuario.cCorreo          =   response.data[0].email;
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
        limpiarCriteriosBsq(){
                this.fillEditarUsuario.cPrimerNombre= "";
                this.fillEditarUsuario.cSegundoNombre= "";
                this.fillEditarUsuario.cUsuario= "";
                this.fillEditarUsuario.cCorreo= "";
                this.fillEditarUsuario.cApellido= "";
                this.fillEditarUsuario.cContrasena= '';
                this.fillEditarUsuario.oFotografia= '';
            },
        getFile(e){
            this.fillEditarUsuario.oFotografia = e.target.files[0];
        },
        setEditarUsuario(){
            if (this.validarRegistrarUsuario()) {
                this.modalShow = true;
                return;
            }
            this.fullscreenLoading=true;
            if (!this.fillEditarUsuario.oFotografia || this.fillEditarUsuario.oFotografia == undefined) {
                //Registrará sin la imágen
                this.setGuardarUsuario(0);
            } else {
                this.setRegistrarArchivo();
            }
        },
        setRegistrarArchivo(){
            this.form.append('file', this.fillEditarUsuario.oFotografia)
            const config = { headers: { 'Content-Type': 'multipart/form-data'}}
            var url = '/archivo/setRegistrarArchivo'
            axios.post(url, this.form, config).then(response =>{
                var nIdFile = response.data[0].nIdFile;
                this.setGuardarUsuario(nIdFile);
            }).catch(error => {
                if (error.response.status == 401) {
                    this.$router.push({name: 'login'})
                    location.reload();
                    sessionStorage.clear();
                    this.fullscreenLoading = false;
                }
            })
        },

        setGuardarUsuario(nIdFile){
            var url = '/administracion/usuario/setEditarUsuario'
            axios.post(url, {
                'nIdUsuario'    :   this.fillEditarUsuario.nIdUsuario,
                'cPrimerNombre' :   this.fillEditarUsuario.cPrimerNombre,
                'cSegundoNombre':   this.fillEditarUsuario.cSegundoNombre,
                'cApellido'     :   this.fillEditarUsuario.cApellido,
                'cUsuario'      :   this.fillEditarUsuario.cUsuario,
                'cCorreo'       :   this.fillEditarUsuario.cCorreo,
                'cContrasena'   :   this.fillEditarUsuario.cContrasena,
                'oFotografia'   :   nIdFile
            }).then(response => {
                // console.log(response.data);
                this.setEditarRolByUsuario();
            }).catch(error => {
                if (error.response.status == 401) {
                    this.$router.push({name: 'login'})
                    location.reload();
                    sessionStorage.clear();
                    this.fullscreenLoading = false;
                }
            })
        },

            setEditarRolByUsuario(){
                var url = '/administracion/usuario/setEditarRolByUsuario'
                axios.post(url, {
                    'nIdUsuario'    :   this.fillEditarUsuario.nIdUsuario,
                    'nIdRol'        :   this.fillEditarUsuario.nIdRol
                }).then(response => {
                    this.fullscreenLoading = false;
                    Swal.fire({
                        icon: 'success',
                        title: 'Se actualizo el usuario correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }).catch(error => {
                    if (error.response.status == 401) {
                        this.$router.push({name: 'login'})
                        location.reload();
                        sessionStorage.clear();
                        this.fullscreenLoading = false;
                    }
                })
            },

        abrirModal(){
            this.modalShow = !this.modalShow;
        },

        getListarRoles(){
                this.fullscreenLoading = true;

                var url = '/administracion/rol/getListarRoles'
                axios.get(url).then(response => {
                    this.listRoles   =   response.data;
                    this.getRolByUsuario();
                }).catch(error => {
                    if (error.response.status == 401) {
                        this.$router.push({name: 'login'})
                        location.reload();
                        sessionStorage.clear();
                        this.fullscreenLoading = false;
                    }
                })
        },
        getRolByUsuario(){
            var url = '/administracion/usuario/getRolByUsuario'
            axios.get(url,{
                params: {
                    'nIdUsuario'    :   this.fillEditarUsuario.nIdUsuario
                }
            }).then(response => {
                this.fillEditarUsuario.nIdRol   =   (response.data.length == 0) ? '' : response.data[0].nIdRol;
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

        validarRegistrarUsuario(){
            this.error = 0;
            this.mensajeError = [];

            if (!this.fillEditarUsuario.cPrimerNombre) {
                this.mensajeError.push("El Primer Nombre es un campo obligatorio")
            }
            if (!this.fillEditarUsuario.cApellido) {
                this.mensajeError.push("El Apellido es un campo obligatorio")
            }
            if (!this.fillEditarUsuario.cUsuario) {
                this.mensajeError.push("El Usuario es un campo obligatorio")
            }
            if (!this.fillEditarUsuario.cCorreo) {
                this.mensajeError.push("El Correo es un campo obligatorio")
            }

            if (!this.fillEditarUsuario.nIdRol) {
                    this.mensajeError.push("Debe seleccionar el Rol, es un campo obligatorio")
                }
            if (this.mensajeError.length) {
                this.error = 1;
            }
            return this.error;
        }

    },

}
</script>

<style>

</style>
