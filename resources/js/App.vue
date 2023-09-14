<template>
<div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <router-link to="/" class="navbar-brand">Licitaciones.info - {{ this.getToken() != null ? usuario.nombre : 'invitado' }}</router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item" v-if="getToken() && isAdmin()">
                        <router-link to="/productos" class="nav-link active">Productos</router-link>
                    </li>
                    <li class="nav-item" v-if="getToken() && isAdmin()">
                        <router-link to="/categorias" class="nav-link active">Categorias</router-link>
                    </li>
                    <li class="nav-item" v-if="getToken() && isAdmin()">
                        <router-link to="/comentarios" class="nav-link active">Comentarios</router-link>
                    </li>
                    <li class="nav-item" v-if="getToken() && isAdmin()">
                        <router-link to="/tags" class="nav-link active">Tags</router-link>
                    </li>
                    <li class="nav-item" v-if="getToken() && isAdmin()">
                        <router-link to="/usuarios" class="nav-link active">Usuario</router-link>
                    </li>
                    <li class="nav-item" v-if="getToken()">
                        <router-link to="/facturas" class="nav-link active">Facturas</router-link>
                    </li>
                    <li class="nav-item" v-if="getToken()">
                        <router-link to="/logout" class="nav-link active">logout</router-link>
                    </li>
                    <li class="nav-item" v-if="!getToken()">
                        <router-link to="/login" class="nav-link active">Login</router-link>
                    </li>
                    
                    <li class="nav-item" v-if="!getToken()">
                        <router-link to="/registrar" class="nav-link active">Registar</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid mt-5">
        <vue-snotify></vue-snotify>
        <router-view/>
    </div>
</div>
</template>
<script>

export default {

    data(){
        return {
            usuario: {
                nombre: null
            }
        }
    },

    mounted(){
        this.usuario = JSON.parse(localStorage.getItem("user"));
    },

    methods: {

        async logout(){
            try {
                await this.axios.get('logout')
                localStorage.removeItem('token')
                localStorage.removeItem('user')
                this.$router.push('/')
            } catch (error) {
                console.log(error.response)
            }
        }

    }

}

</script>