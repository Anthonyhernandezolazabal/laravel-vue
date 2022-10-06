<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Catálogo</h1>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <template v-if="listRolPermisosByUsuario.includes('producto.nuevocatalogo')">
                            <router-link class="btn btn-info btn-sm" :to="{name:'producto.nuevocatalogo', params:{id: fillBsqCatalogoProducto.nIdProducto}}">
                                <i class="fas fa-plus-square"></i> Nuevo Catálogo
                            </router-link>
                        </template>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <button class="btn btn-flat btn-info btnWidth mb-3" @click.prevent="getListarCatalogoProductos" v-loading.fullscreen.lock="fullscreenLoading">Listar</button>
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
                                                <th>Color</th>
                                                <th>Stock</th>
                                                <th>Producto</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in listarProductosPaginated" :key="index">
                                                <td>
                                                    <li class="user-block">
                                                        <img :src="item.path" :alt="item.filename" class="profile-avatar-img img-fluid img-circle">
                                                    </li>
                                                </td>
                                                <td v-text="item.colornombre"></td>
                                                <td v-text="item.stock"></td>
                                                <td v-text="item.producto"></td>
                                                <td>
                                                    <template v-if="listRolPermisosByUsuario.includes('producto.editar')">
                                                        <router-link class="btn btn-flat btn-info btn-sm" :to="{name:'producto.editar', params:{id: item.id}}">
                                                            <i class="fas fa-pencil-alt"></i> Editar
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
                fillBsqCatalogoProducto: {
                    nIdProducto: this.$attrs.id,
                },
                listCatalogoProductos: [],
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
                let a = this.listCatalogoProductos.length,
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
                return this.listCatalogoProductos.slice(inicio, fin);
            },
            pagesList() {
                let a = this.listCatalogoProductos.length,
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
        methods: {
            limpiarBandejaUsuarios(){
                this.listCatalogoProductos   =   [];
            },
           
            getListarCatalogoProductos(){
                this.fullscreenLoading = true;

                var url = '/configuracion/producto/getListarCatalogoProductos'
                axios.get(url, {
                    params: {
                        'nIdProducto'  :   this.fillBsqCatalogoProducto.nIdProducto,
                    }
                }).then(response => {
                    console.log("LISTA CAT :",response.data)
                    this.inicializarPaginacion();
                    this.listCatalogoProductos   =   response.data;
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
