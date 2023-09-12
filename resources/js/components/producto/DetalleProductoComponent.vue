<template>
    <div class="card" style="width: 100%;">
        <img src="https://picsum.photos/500/500" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">{{ producto.nombre }}</h5>
            <h5>categoria <span class="badge bg-secondary">{{ producto.categoria.nombre}}</span></h5>
            <span class="badge bg-secondary" v-for="tag in producto.tags">{{ tag.nombre}}</span>
            <p class="card-text">{{ producto.descripcion }}</p>
            
            <form @submit.prevent="agregarAlCarro()">
                <div class="input-group mb-3">
                    <input type="number" class="form-control" v-model="form.cantidad" placeholder="cantidad a agregar" aria-label="cantidad a agregar" aria-describedby="button-addon2">
                    <button class="btn btn-success" type="submit" id="button-addon2">Agregar</button>
                </div>
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
                cantidad: 1            
            }
        }
    },

    methods: {

        async agregarAlCarro(){
            try {
                const request = {
                    producto_id: this.producto.id,
                    cantidad: this.form.cantidad,
                }
                await this.axios.post('/orden/agregar-producto', request)
                this.limpiar()
                this.$router.push('/')
            }catch(error){
                console.log(error)
            }
        },

        limpiar(){
            this.form.cantidad = 1      
        }

    }

}

</script>