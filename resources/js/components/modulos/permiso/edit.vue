<template>
    <div>
      <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Editar Permiso</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
          <div class="content container-fluid">
              <div class="card">
                  <div class="card-header">
                      <div class="card-tools"><!-- Lado izquierdo -->
                          <router-link :to="'/permiso'" class="btn btn-info btn-sm">
                              <i class="fas fa-plus-square"></i> Regresar
                          </router-link>
                      </div>
                  </div>

                  <div class="card-body">
                      <div class="container-fluid">

                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Formulario Editar Permiso</h3>
                            </div>
                            <div class="card-body">
                                <form role="form">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Nombre</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" v-model="fillEditarPermiso.cNombre" @keyup.enter="setEditarPermiso">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Url Amigable</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" v-model="fillEditarPermiso.cSlug" @keyup.enter="setEditarPermiso">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-4 offset-4">
                                        <button class="btn btn-flat btn-info btnWidth" @click.prevent="setEditarPermiso" v-loading.fullscreen.lock="fullscreenLoading">Editar</button>
                                        <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarCriterios">Limpiar</button>
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
              fillEditarPermiso: {
                nIdPermiso: this.$route.params.id,
                  cNombre: "",
                  cSlug: "",
              },
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
              mensajeError: []
          }
      },
        mounted() {
            this.getListarPermisos();
        },

      methods: {

        limpiarCriteriosBsq(){
            this.fillEditarPermiso.cNombre= "";
            this.fillEditarPermiso.cSlug= "";
        },
        abrirModal(){
              this.modalShow = !this.modalShow;
          },


          setEditarPermiso(){
                if (this.validarEditarPermiso()) {
                    this.modalShow = true;
                    return;
                }
                this.fullscreenLoading = true;

                var url = '/administracion/permiso/setEditarPermiso'
                axios.post(url, {
                    'nIdPermiso'            :   this.fillEditarPermiso.nIdPermiso,
                    'cNombre'               :   this.fillEditarPermiso.cNombre,
                    'cSlug'                 :   this.fillEditarPermiso.cSlug
                }).then(response => {
                    this.fullscreenLoading = false;
                    Swal.fire({
                        icon: 'success',
                        title: 'Se actualizo el permiso correctamente',
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

        getListarPermisos(){
            this.fullscreenLoading = true;

            var url = '/administracion/permiso/getListarPermisos'
            axios.get(url, {
                params: {
                    'nIdPermiso'   :   this.fillEditarPermiso.nIdPermiso
                }
            }).then(response => {
                this.fillEditarPermiso.cNombre =   response.data[0].name;
                this.fillEditarPermiso.cSlug   =   response.data[0].slug;
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

        validarEditarPermiso(){
        this.error = 0;
        this.mensajeError = [];

        if (!this.fillEditarPermiso.cNombre) {
            this.mensajeError.push("El Primer Nombre es un campo obligatorio")
        }
        if (!this.fillEditarPermiso.cSlug) {
            this.mensajeError.push("La Url amigable es un campo obligatorio")
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
