<template>
    <div>
      <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Crear Rol</h1>
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
                          <router-link :to="'/rol'" class="btn btn-info btn-sm">
                              <i class="fas fa-plus-square"></i> Regresar
                          </router-link>
                      </div>
                  </div>

                  <div class="card-body">
                      <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-5">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Formulario Registrar Rol</h3>
                                    </div>
                                    <div class="card-body">
                                        <form role="form">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="col-md-3 col-form-label">Nombre</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" v-model="fillCrearRol.cNombre" @keyup.enter="setRegistrarRolPermisos">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="col-md-3 col-form-label">Url Amigable</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" v-model="fillCrearRol.cSlug" @keyup.enter="setRegistrarRolPermisos">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                                <button class="btn btn-float btn-info btnwidth" @click.prevent="setRegistrarRolPermisos" v-loading.fullscreen.lock="fullscreenLoading">Registrar</button>
                                                <button class="btn btn-float btn-default btnwidth" @click.prevent="limpiarCriteriosBsq">Limpiar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Listar Permisos</h3>
                                    </div>



                                    <div class="card-body table-responsive">
                                        <template v-if="listPermisosFilter.length">
                                            <div class="scrollTable2">
                                                <table class="table table-hover table-head-fixed text-nowrap projects">
                                                    <thead>
                                                        <tr>
                                                            <th>Acciones</th>
                                                            <th>Foto</th>
                                                            <th>Nombre</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in listPermisosFilter" :key="index"  @click.prevent="marcarFila(index)">
                                                            <td>
                                                                <el-checkbox v-model="item.checked"></el-checkbox>
                                                            </td>
                                                            <td v-text="item.name"></td>
                                                            <td v-text="item.slug"></td>

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
              fillCrearRol: {
                  cNombre: "",
                  cSlug: "",
              },
              listPermisos: [],
              listPermisosFilter: [],
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
      mounted(){
            this.getListarPermisosByRol();
      },
      methods: {

        limpiarCriteriosBsq(){
            this.fillCrearRol.cNombre= "";
            this.fillCrearRol.cSlug= "";
        },

        getListarPermisosByRol(){
                var ruta = '/administracion/rol/getListarPermisosByRol'
                axios.get(ruta).then( response => {
                    console.log("response ::",response)
                    this.listPermisos = response.data;
                    this.filterPermisosByRol();
                }).catch(error => {
                    if (error.response.status == 401) {
                        this.$router.push({name: 'login'})
                        location.reload();
                        sessionStorage.clear();
                        this.fullscreenLoading = false;
                    }
                })
        },



        filterPermisosByRol() {
                let me = this;
                me.listPermisos.map(function(x, y){
                    me.listPermisosFilter.push({
                        'id'        :   x.id,
                        'name'      :   x.name,
                        'slug'      :   x.slug,
                        'checked'   :   false
                    })
                })
            },


            marcarFila(index){
                this.listPermisosFilter[index].checked  =   !this.listPermisosFilter[index].checked;
            },




            setRegistrarRolPermisos(){
                if (this.validarRegistrarRolPermisos()) {
                    this.modalShow = true;
                    return;
                }
                this.fullscreenLoading = true;

                var url = '/administracion/rol/setRegistrarRolPermisos'
                axios.post(url, {
                    'cNombre'               :   this.fillCrearRol.cNombre,
                    'cSlug'                 :   this.fillCrearRol.cSlug,
                    'listPermisosFilter'    :   this.listPermisosFilter
                }).then(response => {
                    this.fullscreenLoading = false;
                    this.$router.push('/rol');
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
          validarRegistrarRolPermisos(){
              this.error = 0;
              this.mensajeError = [];

              if (!this.fillCrearRol.cNombre) {
                  this.mensajeError.push("El Primer Nombre es un campo obligatorio")
              }
              if (!this.fillCrearRol.cSlug) {
                  this.mensajeError.push("La Url amigable es un campo obligatorio")
              }

                let contador = 0;
                this.listPermisosFilter.map(function(x, y){
                    if (x.checked == true) {
                        contador++;
                    }
                })
                if (contador == 0) {
                    this.mensajeError.push("Debe seleccionar al menos un permiso");
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
