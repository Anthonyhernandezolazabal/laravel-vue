<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Producto</h1>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <template v-if="listRolPermisosByUsuario.includes('producto.crear')">
                            <router-link class="btn btn-info btn-sm" :to="{name: 'producto.crear'}">
                                <i class="fas fa-plus-square"></i> Nuevo Producto
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
                                                    <input type="text" class="form-control" v-model="fillBsqProducto.cNombre" @keyup.enter="getListarProductos">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Descripción</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" v-model="fillBsqProducto.cDescripcion" @keyup.enter="getListarProductos">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Categoria</label>
                                                <div class="col-md-9">
                                                    <el-select  v-model="fillBsqProducto.nIdCategoria"
                                                                placeholder="Seleccione una Categoria"
                                                                clearable>
                                                        <el-option
                                                            v-for="item in listCategorias"
                                                            :key="item.id"
                                                            :label="item.name"
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
                                        <button class="btn btn-flat btn-info btnWidth" @click.prevent="getListarProductos" v-loading.fullscreen.lock="fullscreenLoading">Buscar</button>
                                        <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarCriteriosBsq">Limpiar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Bandeja de Resultados</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <template v-if="listarProductosPaginated.length">
                                    <table class="table table-hover table-head-fixed text-nowrap projects">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Descripción</th>
                                                <th>Stock</th>
                                                <th>Precio</th>
                                                <th>Categoria</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in listarProductosPaginated" :key="index">
                                                <td v-text="item.name"></td>
                                                <td v-text="item.description"></td>
                                                <template>
                                                    <div v-if="item.totalstock == null">
                                                        <td>-</td>
                                                    </div>
                                                    <div v-else>
                                                        <td v-text="item.totalstock"></td>
                                                    </div>
                                                </template>
                                                <td v-text="item.price"></td>
                                                <td v-text="item.categoria"></td>
                                                <td>
                                                    <template v-if="listRolPermisosByUsuario.includes('producto.editar')">
                                                        <router-link class="btn btn-flat btn-info btn-sm" :to="{name:'producto.editar', params:{id: item.id}}">
                                                            <i class="fas fa-pencil-alt"></i> Editar
                                                        </router-link>
                                                    </template>

                                                    <template v-if="listRolPermisosByUsuario.includes('producto.catalago')">
                                                        <router-link class="btn btn-flat btn-primary btn-sm" :to="{name:'producto.catalago', params:{id: item.id}}">
                                                            <i class="fas fa-shopping-bag"></i> Catálogo
                                                        </router-link>
                                                    </template>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="card-footer clearfix">
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <li class="page-item" v-if="pageNumber > 0">
                                                <a href="#" class="page-link" @click.prevent="prevPage">Ant</a>
                                            </li>
                                            <li class="page-item" v-for="(page, index) in pagesList" :key="index"
                                                :class="[page == pageNumber ? 'active' : '']">
                                                <a href="#" class="page-link" @click.prevent="selectPage(page)"> {{ page+1 }} </a>
                                            </li>
                                            <li class="page-item" v-if="pageNumber < pageCount - 1">
                                                <a href="#" class="page-link" @click.prevent="nextPage" >Post</a>
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
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                fillBsqProducto: {
                    cNombre : '',
                    cDescripcion: '',
                    nIdCategoria: ''
                },
                listProductos: [],
                listCategorias: [],
                listRolPermisosByUsuario: JSON.parse(sessionStorage.getItem('listRolPermisosByUsuario')),
                fullscreenLoading: false,
                pageNumber: 0,
                perPage: 5
            }
        },
        computed: {
            // Obtener el número de páginas
            pageCount() {
                // 20
                // 5
                // 20 /5 = 4
                let a = this.listProductos.length,
                    b = this.perPage;
                return Math.ceil(a / b);
            },
            // Obtener registros paginados
            listarProductosPaginated(){
                // 0 * 5 = 0
                // 0 + 5 = 5
                // 0 - (5-1)
                // 1 * 5 = 5
                // 5 + 5 = 10
                // 5 - (10-1)
                // 2 * 5 = 10
                // 10 + 5 = 15
                // 10 - (15-1)

                let inicio = this.pageNumber * this.perPage,
                    fin    = inicio + this.perPage;
                return this.listProductos.slice(inicio, fin);
            },
            pagesList() {
                let a = this.listProductos.length,
                    b = this.perPage;
                let pageCount = Math.ceil(a / b);
                let count = 0,
                    pagesArray = [];

                // 0 < 4 => 0
                // 1 < 4 => 0, 1
                // 2 < 4 => 0, 1, 2
                // 3 < 4 => 0, 1, 2, 3
                // 4 < 4 ??
                while (count < pageCount) {
                    pagesArray.push(count);
                    count++;
                }
                return pagesArray;
            }
        },
        mounted() {
            this.getListarCategorias();
        },
        methods: {
            limpiarCriteriosBsq(){
                this.fillBsqProducto.cNombre     =   '';
                this.fillBsqProducto.cDescripcion    =   '';
            },
            limpiarBandejaUsuarios(){
                this.listProductos   =   [];
            },
            getListarCategorias(){
                this.fullscreenLoading = true;

                var url = '/configuracion/categoria/getListarCategorias'
                axios.get(url).then(response => {
                    this.listCategorias   =   response.data;
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
            getListarProductos(){
                this.fullscreenLoading = true;

                var url = '/configuracion/producto/getListarProductos'
                axios.get(url, {
                    params: {
                        'cNombre'       :   this.fillBsqProducto.cNombre,
                        'cDescripcion'  :   this.fillBsqProducto.cDescripcion,
                        'nIdCategoria'  :   this.fillBsqProducto.nIdCategoria,
                    }
                }).then(response => {
                    console.log("LISTA PROD :",response.data)
                    this.inicializarPaginacion();
                    this.listProductos   =   response.data;
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
            }
        }
    }
</script>

<style>

</style>
