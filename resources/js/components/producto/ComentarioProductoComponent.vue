<template>

<div class="card">
    <div class="card-body">
        
        <h2>Lista de comentarios</h2>

        <ol class="list-group list-group-numbered mb-4">
            <li v-for="comentario in producto.comentarios" class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                <div class="fw-bold">{{ comentario.user.nombre }}</div>
                    {{ comentario.texto }}
                </div>
                <span class="badge bg-primary rounded-pill">{{ comentario.created_at }}</span>
            </li>
        </ol>

        <form @submit.prevent="crearComentario()">
            <div class="mb-3">
                <textarea class="form-control" v-model="form.texto" id="descripcion" rows="3" placeholder="Escribe tu comentario aqui"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Comentario</button>
        </form>

    </div>
</div>


</template>
<script>

export default {

    props: {
        producto:{
            type: Object
        }
    },

    data(){
        return {
            form: {
                texto: null
            }
        }
    },

    methods: {

        async crearComentario(){
            try {
                const request = {
                    producto_id : this.producto.id,
                    texto: this.form.texto
                }
                const response = await this.axios.post('/comentario/crear', request)
                this.limpiar()
                this.$emit('submit')
            }catch(error){
                if(error.response.status === 401){
                    this.$router.push('/login')
                }
            }
        },

        limpiar(){
            this.form.texto = null
        }

    }

}

</script>