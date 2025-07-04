import Vue from "vue"
import Router from "vue-router"

Vue.use(Router)
function verificarAcceso(to, from, next) {
    let authUser = JSON.parse(sessionStorage.getItem("authUser"));
    if(authUser)    {
        let listRolPermisosByUsuario = JSON.parse(sessionStorage.getItem("listRolPermisosByUsuario"));
        if(listRolPermisosByUsuario.includes(to.name)){
            next();
        }else{
            let listRolPermisosByUsuarioFilter = [];
            listRolPermisosByUsuario.map(function(x) {
                if (x.includes('index')) {
                    listRolPermisosByUsuarioFilter.push(x);
                }
            })
            if (to.name == 'dashboard.index') {
                next({ name: listRolPermisosByUsuarioFilter[0] });
            } else {
                next(from.path)
            }
        }
    } else {
        next('/login')
    }

}

export const rutas =
[
    {
        path: "/login",
        name: "login",
        component: require("./components/modulos/authenticate/login").default,
        beforeEnter: (to, from, next) => {
            let authUser = JSON.parse(sessionStorage.getItem('authUser'));
            if (authUser) {
                next({ name: 'dashboard.index' });
            } else {
                next();
            }
        }
    },


    {
        path: "/",
        name: 'dashboard.index',
        component: require("./components/modulos/dashboard/index").default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },

    {
        path: "/pedido",
        name: 'pedido.index',
        component: require("./components/modulos/pedido/index").default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },

    {
        path: "/cliente",
        name: 'cliente.index',
        component: require("./components/modulos/cliente/index").default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },




    {
        path: "/categoria",
        name: 'categoria.index',
        component: require("./components/modulos/categoria/index").default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },

    {
        path: "/categoria/crear",
        name: 'categoria.crear',
        component: require("./components/modulos/categoria/create").default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },

    {
        path: "/categoria/editar",
        name: 'categoria.editar',
        component: require("./components/modulos/categoria/edit").default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },

    {
        path: "/cliente",
        name: 'cliente.index',
        component: require("./components/modulos/cliente/index").default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },

    {
        path: "/permiso",
        name: 'permiso.index',
        component: require("./components/modulos/permiso/index").default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },



    {
        path: "/permiso/crear",
        name: 'permiso.crear',
        component: require("./components/modulos/permiso/create").default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },

    {
        path: "/permiso/editar/:id",
        name: "permiso.editar",
        component: require("./components/modulos/permiso/edit").default,
        props:true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },


    {
        path: "/producto",
        name: "producto.index",
        component: require("./components/modulos/producto/index").default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },

    {
        path: "/producto/crear",
        name: 'producto.crear',
        component: require("./components/modulos/producto/create").default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: "/producto/editar/:id",
        name: "producto.editar",
        component: require("./components/modulos/producto/edit").default,
        props:true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: "/producto/catalago/:id",
        name: "producto.catalago",
        component: require("./components/modulos/producto/catalago").default,
        props:true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: "/producto/catalago/nuevo-catalogo/:id",
        name: "producto.nuevocatalogo",
        component: require("./components/modulos/producto/createCatalogo").default,
        props:true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },


    {
        path: "/reporte",
        name: "reporte.index",
        component: require("./components/modulos/reporte/index").default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: "/rol",
        name: "rol.index",
        component: require("./components/modulos/rol/index").default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: "/rol/crear",
        name: "rol.crear",
        component: require("./components/modulos/rol/create").default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: "/usuario",
        name: "usuario.index",
        component: require("./components/modulos/usuario/index").default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: "/usuario/editar/:id",
        name: "usuario.editar",
        component: require("./components/modulos/usuario/edit").default,
        props:true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: "/usuario/ver/:id",
        name: "usuario.ver",
        component: require("./components/modulos/usuario/view").default,
        props:true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: "/usuario/permiso/:id",
        name: "usuario.permiso",
        component: require("./components/modulos/usuario/permission").default,
        props:true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },
    {
        path: "/rol/editar/:id",
        name: "rol.editar",
        component: require("./components/modulos/rol/edit").default,
        props:true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },

    {
        path: "/usuario/crear",
        name: "usuario.crear",
        component: require("./components/modulos/usuario/create").default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next)
        }
    },

    {
        path: "*",
        component: require("./components/plantilla/404").default,

    }
]

export default new Router({
    routes:rutas,
    mode: "history",
    // linkExactActiveClass: 'active' //Activar el módulo donde estoy
    linkActiveClass: 'active' //El módulo se mantenga seleccionado
})
