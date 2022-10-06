<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Nuevo catálogo del producto</h1>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <router-link class="btn btn-info btn-sm" :to="'/producto'">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </router-link>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Formulario Registrar Producto</h3>
                            </div>
                            <div class="card-body">
                                <form role="form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Imágen del Producto</label>
                                                <div class="col-md-9">
                                                    <input type="file" class="form-control" @change="getFile">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Stock</label>
                                                <div class="col-md-9">
                                                    <el-input-number v-model="fillCrearCatalogoProducto.cStock" controls-position="right" @keyup.enter="setRegistrarCatalogoProducto" :min="1"></el-input-number>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Producto</label>
                                                <div class="col-md-9">
                                                    <p class="form-control form-control-border border-width-2" v-text="nombreProducto"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Color</label>
                                                <div class="col-md-9">
                                                    <el-select  v-model="fillCrearCatalogoProducto.cColorPaleta"
                                                                placeholder="Seleccione color"
                                                                clearable>
                                                        <el-option
                                                            v-for="item in listColor"
                                                            :key="item.id"
                                                            :label="item.nombre"
                                                            :value="item.id">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-4 offset-4">
                                        <button class="btn btn-flat btn-info btnWidth" @click.prevent="setRegistrarCatalogoProducto" v-loading.fullscreen.lock="fullscreenLoading">Registrar</button>
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
            return {
                fillCrearCatalogoProducto: {
                    cStock: 1,
                    cColorPaleta: '',
                    nIdProducto: this.$attrs.id,
                    oImagen: null
                },
                nombreProducto:"",
                listColor: [],
                fullscreenLoading: false,
                modalShow: false,
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
            this.getListarCategorias();
            this.getListarProductos();
        },
        methods: {
            limpiarCriterios(){
                this.fillCrearCatalogoProducto.cStock      = '';
                this.fillCrearCatalogoProducto.cColorPaleta = '';
            },
            abrirModal(){
                this.modalShow = !this.modalShow;
            },
            getListarCategorias(){
                this.fullscreenLoading = true;

                var url = '/configuracion/colorproductos/getListarColores'
                axios.get(url).then(response => {
                    this.listColor   =   response.data;
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
                this.fillCrearCatalogoProducto.oImagen = e.target.files[0];
            },

            setRegistrarCatalogoProducto(){
                if (this.validarRegistrarProducto()) {
                    this.modalShow = true;
                    return;
                }
                this.fullscreenLoading = true;


                let fillCrearCatalogoProducto = new FormData();
                for(let key in this.fillCrearCatalogoProducto){
                    fillCrearCatalogoProducto.append(key, this.fillCrearCatalogoProducto[key]);
                }
                const config = { headers: { 'Content-Type': 'multipart/form-data'}}
                var url = '/configuracion/producto/setRegistrarCatalogoProducto'
                axios.post(url, fillCrearCatalogoProducto,config).then(response => {
                    this.fullscreenLoading = false;
                    this.$router.push('/producto/');
                }).catch(error => {
                    if (error.response.status == 401) {
                        this.$router.push({name: 'login'})
                        location.reload();
                        sessionStorage.clear();
                        this.fullscreenLoading = false;
                    }
                })



            },
            validarRegistrarProducto(){
                this.error = 0;
                this.mensajeError = [];

                if (!this.fillCrearCatalogoProducto.cStock) {
                    this.mensajeError.push("El Stok es un campo obligatorio")
                }
                if (!this.fillCrearCatalogoProducto.cColorPaleta) {
                    this.mensajeError.push("Debe seleccionar un color, es un campo obligatorio")
                }

                if (this.mensajeError.length) {
                    this.error = 1;
                }
                return this.error;
            },
            getListarProductos(){
                this.fullscreenLoading = true;

                var url = '/configuracion/producto/getListarProductos'
                axios.get(url, {
                    params: {
                        'nIdProducto'   :   this.fillCrearCatalogoProducto.nIdProducto
                    }
                }).then(response => {
                    this.nombreProducto         =   response.data[0].name;
                }).catch(error => {
                    if (error.response.status == 401) {
                        this.$router.push({name: 'login'})
                        location.reload();
                        sessionStorage.clear();
                        this.fullscreenLoading = false;
                    }
                })
            },
        }
    }
</script>

<style>

</style>
