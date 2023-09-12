<template>
    <form @submit.prevent="login()">
        <div class="form-floating mb-3">
            <input type="email" class="form-control" v-model="form.email" id="email" placeholder="name@example.com">
            <label for="email">Email address</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" v-model="form.password" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</template>
<script>

export default {

data(){
    return {
        form: {
            email: null,
            password: null,
        }
    }
},

methods: {

    /** Loguea a un usuario, se recupera token de autenticacion */
    async login(){
        try {
            const registro_response = await this.axios.post("/login", this.form);
            localStorage.setItem("token", registro_response.data.access_token);
            localStorage.setItem("admin", JSON.stringify(registro_response.data.data));
            this.$router.push("/")
        }catch (error){
            console.log(error)
        }
    }

}

}

</script>