<template>

    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Usuario</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>


        <div class="content container-fluid">

            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">





                                <template v-if="!fillVerUsuario.cRutaArchivo">
                                    <img class="profile-user-img img-fluid img-circle img-max-height" src="/img/avatar.png" alt="User profile picture">
                                </template>
                                <template v-else>
                                    <img :src="fillVerUsuario.cRutaArchivo" :alt="cNombreCompleto" class="profile-user-img img-fluid img-circle img-max-height">
                                </template>


                            </div>

                            <h3 class="profile-username text-center">{{ cNombreCompleto }}</h3>
                            <p class="text-muted text-center">{{ fillVerUsuario.cNombreRol }}</p>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <div class="card-header">
                            <h3 class="card-title">Sobre mí</h3>
                        </div>
                        <div class="card-body">
                            <strong><i class="fab fa-mailchimp"></i> Nombre completo</strong>

                            <p class="text-muted" v-text="cNombreCompleto"></p>

                            <hr>

                            <strong><i class="fas fa-envelope-open-text"></i> Correo Electrónico</strong>

                            <p class="text-muted" v-text="fillVerUsuario.cCorreo"></p>


                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>







                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills position-reverse">
                                <li class="nav-item">
                                    <router-link class="nav-link active" data-toggle="tab" :to="'/usuario'">
                                        <i class="fas fa-arrow-left"></i> Regresar
                                    </router-link>
                                </li>

                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-4 col-form-label">Primer Nombre</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" v-model="fillEditarUsuario.cPrimerNombre" @keyup.enter="setEditarUsuario">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-4 col-form-label">Segundo Nombre</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" v-model="fillEditarUsuario.cSegundoNombre" @keyup.enter="setEditarUsuario">

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName2" class="col-sm-4 col-form-label">Apellidos</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" v-model="fillEditarUsuario.cApellido" @keyup.enter="setEditarUsuario">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName2" class="col-sm-4 col-form-label">Usuario</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" v-model="fillEditarUsuario.cUsuario" @keyup.enter="setEditarUsuario">

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName2" class="col-sm-4 col-form-label">Correo Electrónico</label>
                                            <div class="col-sm-8">
                                                <input type="email" class="form-control" v-model="fillEditarUsuario.cCorreo" @keyup.enter="setEditarUsuario">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputExperience"
                                                class="col-sm-4 col-form-label">Contraseña</label>
                                            <div class="col-sm-8">
                                                <el-input placeholder="Ingrese una contraseña" v-model="fillEditarUsuario.cContrasena" @keyup.enter="setEditarUsuario" show-password></el-input>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputSkills" class="col-sm-4 col-form-label">Fotografía</label>
                                            <div class="col-sm-8">

                                                <input type="file" class="form-control" @change="getFile">

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-12 col-sm-12">
                                                <button type="submit" class="btn btn-flat btn-info btn-block" @click.prevent="setEditarUsuario" v-loading.fullscreen.lock="fullscreenLoading">Guardar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
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
                },
                fillVerUsuario: {
                    nIdUsuario: this.$route.params.id,
                    cPrimerNombre: '',
                    cSegundoNombre: '',
                    cApellido: '',
                    cUsuario: '',
                    cCorreo: '',
                    cContrasena: '',
                    oFotografia: '',
                    cRutaArchivo: '',
                    cNombreRol: ''
                },
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
            this.getRolByUsuario();
        },
        computed:{
            cNombreCompleto(){
                return this.fillVerUsuario.cPrimerNombre + " " + this.fillVerUsuario.cSegundoNombre + " " + this.fillVerUsuario.cApellido
            }

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
                    this.getUsuarioEditar(response.data[0])
                    this.getUsuarioEditarVer(response.data[0])
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
            getUsuarioEditar(data){
                    this.fillEditarUsuario.cPrimerNombre    =   data.firstname;
                    this.fillEditarUsuario.cSegundoNombre   =   data.secondname;
                    this.fillEditarUsuario.cApellido        =   data.lastname;
                    this.fillEditarUsuario.cUsuario         =   data.username;
                    this.fillEditarUsuario.cCorreo          =   data.email;
            },
            getUsuarioEditarVer(data){
                    this.fillVerUsuario.cPrimerNombre    =   data.firstname;
                    this.fillVerUsuario.cSegundoNombre   =   data.secondname;
                    this.fillVerUsuario.cApellido        =   data.lastname;
                    this.fillVerUsuario.cUsuario         =   data.username;
                    this.fillVerUsuario.cCorreo          =   data.email;
                    this.fillVerUsuario.cRutaArchivo        =   data.profile_image;
            },

            getRolByUsuario(){
                var url = '/administracion/usuario/getRolByUsuario'
                axios.get(url,{
                    params: {
                        'nIdUsuario'    :   this.fillEditarUsuario.nIdUsuario
                    }
                }).then(response => {
                    this.fillVerUsuario.cNombreRol   =   (response.data.length == 0) ? '' : response.data[0].name;
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
                    this.getRefrescarUsuarioAutenticado();
                })
            },
            getRefrescarUsuarioAutenticado() {
                var url = '/authenticate/getRefrescarUsuarioAutenticado'
                axios.get(url).then(response => {
                    EventBus.$emit('verifyAuthenticatedUser', response.data);
                    this.fullscreenLoading = false;
                    this.getUsuarioById();
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

                if (this.mensajeError.length) {
                    this.error = 1;
                }
                return this.error;
            }

        }

    }

</script>

<style>
    .position-reverse{
        flex-direction: row-reverse !important;
    }
    .img-max-heigth{
        max-height: 100px;
    }

</style>
