<template>
  <div>
    <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1 class="m-0">Crear usuario</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Usuario</a></li>
                          <li class="breadcrumb-item active">Crear usuario</li>
                      </ol>
                  </div><!-- /.col -->
              </div><!-- /.row -->
          </div><!-- /.container-fluid -->
      </div>
        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools"><!-- Lado izquierdo -->
                        <router-link :to="'/usuario'" class="btn btn-info btn-sm">
                            <i class="fas fa-plus-square"></i> Regresar
                        </router-link>
                    </div>
                </div>

                <div class="card-body">
                    <div class="container-fluid">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Formulario Registrar Usuario</h3>
                            </div>
                            <div class="card-body">
                                <form role="form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Primer Nombre</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" v-model="fillCrearUsuario.cPrimerNombre" @keyup.enter="setRegistrarUsuario">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Segundo Nombre</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" v-model="fillCrearUsuario.cSegundoNombre" @keyup.enter="setRegistrarUsuario">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Apellidos</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" v-model="fillCrearUsuario.cApellido" @keyup.enter="setRegistrarUsuario">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Correo Electrónico</label>
                                                <div class="col-md-9">
                                                    <input type="email" class="form-control" v-model="fillCrearUsuario.cCorreo" @keyup.enter="setRegistrarUsuario">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Usuario</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" v-model="fillCrearUsuario.cUsuario" @keyup.enter="setRegistrarUsuario">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Contraseña</label>
                                                <div class="col-md-9">
                                                    <el-input placeholder="Ingresa tu contraseña" v-model="fillCrearUsuario.cContrasena" @keyup.enter="setRegistrarUsuario" show-password></el-input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Rol</label>
                                                <div class="col-md-9">
                                                    <el-select @keyup.enter="getListaUsuarios" v-model="fillCrearUsuario.nIdRol" placeholder="Selecciona un rol" clearable>
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
                                                <label class="col-md-3 col-form-label">Fotografía</label>
                                                <div class="col-md-9">
                                                    <input type="file" class="form-control" @change="getFile">
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
                            <button class="btn btn-float btn-info btnwidth" @click.prevent="setRegistrarUsuario" v-loading.fullscreen.lock="fullscreenLoading">Registrar</button>
                            <button class="btn btn-float btn-default btnwidth" @click.prevent="limpiarCriteriosBsq">Limpiar</button>
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
            fillCrearUsuario: {
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
        this.getListarRoles();
    },
    methods: {

        limpiarCriteriosBsq(){
                this.fillCrearUsuario.cPrimerNombre= "";
                this.fillCrearUsuario.cSegundoNombre= "";
                this.fillCrearUsuario.cUsuario= "";
                this.fillCrearUsuario.cCorreo= "";
                this.fillCrearUsuario.cApellido= "";
                this.fillCrearUsuario.cContrasena= '';
                this.fillCrearUsuario.oFotografia= '';
            },
        getFile(e){
            this.fillCrearUsuario.oFotografia = e.target.files[0];
        },
        setRegistrarUsuario(){
            if (this.validarRegistrarUsuario()) {
                this.modalShow = true;
                return;
            }
            this.fullscreenLoading=true;
            if (!this.fillCrearUsuario.oFotografia || this.fillCrearUsuario.oFotografia == undefined) {
                //Registrará sin la imágen
                this.setGuardarUsuario(0);
            } else {
                this.setRegistrarArchivo();
            }
        },
        setRegistrarArchivo(){
            this.form.append('file', this.fillCrearUsuario.oFotografia)
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
            var url = '/administracion/usuario/setRegistrarUsuario'
            axios.post(url, {
                'cPrimerNombre' :   this.fillCrearUsuario.cPrimerNombre,
                'cSegundoNombre':   this.fillCrearUsuario.cSegundoNombre,
                'cApellido'     :   this.fillCrearUsuario.cApellido,
                'cUsuario'      :   this.fillCrearUsuario.cUsuario,
                'cCorreo'       :   this.fillCrearUsuario.cCorreo,
                'cContrasena'   :   this.fillCrearUsuario.cContrasena,
                'oFotografia'   :   nIdFile
            }).then(response => {
                this.setEditarRolByUsuario(response.data);
            }).catch(error => {
                if (error.response.status == 401) {
                    this.$router.push({name: 'login'})
                    location.reload();
                    sessionStorage.clear();
                    this.fullscreenLoading = false;
                }
            })
        },


        setEditarRolByUsuario(nIdUsuario){
                var url = '/administracion/usuario/setEditarRolByUsuario'
                axios.post(url, {
                    'nIdUsuario'    :   nIdUsuario,
                    'nIdRol'        :   this.fillCrearUsuario.nIdRol
                }).then(response => {
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

        abrirModal(){
            this.modalShow = !this.modalShow;
        },
        getListarRoles(){
            this.fullscreenLoading = true;

            var url = '/administracion/rol/getListarRoles'
            axios.get(url).then(response => {
                this.listRoles   =   response.data;
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

            if (!this.fillCrearUsuario.cPrimerNombre) {
                this.mensajeError.push("El Primer Nombre es un campo obligatorio")
            }
            if (!this.fillCrearUsuario.cApellido) {
                this.mensajeError.push("El Apellido es un campo obligatorio")
            }
            if (!this.fillCrearUsuario.cUsuario) {
                this.mensajeError.push("El Usuario es un campo obligatorio")
            }
            if (!this.fillCrearUsuario.cCorreo) {
                this.mensajeError.push("El Correo es un campo obligatorio")
            }
            if (!this.fillCrearUsuario.cContrasena) {
                this.mensajeError.push("La Contraseña es un campo obligatorio")
            }

            if (!this.fillCrearUsuario.nIdRol) {
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

</style>vue
