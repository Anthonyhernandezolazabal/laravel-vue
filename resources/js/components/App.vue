<template>
<div>
    <Navbar :ruta="ruta"></Navbar>

    <Sidebar :ruta="ruta"></Sidebar>

    <div class="content-wrapper">
        <transition name="slide-fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>


    <Footer></Footer>

  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
</div>
</template>

<script>
    import Navbar from "./plantilla/Navbar";
    import Footer from "./plantilla/Footer";
    import Sidebar from "./plantilla/Sidebar";
    export default {
        props:["ruta"],
        components: {Navbar,Footer,Sidebar}

    }
</script>

<style>

</style>
