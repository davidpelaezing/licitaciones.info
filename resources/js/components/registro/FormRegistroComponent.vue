<template>
    <form @submit.prevent="registrar()">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" v-model="form.nombre" id="nombre" placeholder="Nombre completo">
            <label for="nombre">Nombre completo</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" v-model="form.email" id="email" placeholder="name@example.com">
            <label for="email">Email address</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" v-model="form.password" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</template>
<script>

export default {

data(){
    return {
        form: {
            nombre: null,
            email: null,
            password: null,
        }
    }
},

methods: {

    /** Registra un usuario */
    async registrar(){
        try {
            const registro_response = await this.axios.post("/registrar", this.form);
            this.$router.push('/login')
        }catch (error){
            console.log(error.response)
        }
    }

}

}

</script>