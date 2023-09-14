<template>
    <div class="card shadow-sm" style="width: 100%;">
        <img :src="cargarlink(producto.imagen_url)" width="200px" height="250px" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">{{ producto.nombre }}</h5>
            <h4 class="card-title">${{ producto.precio }}</h4>
            <span class="badge bg-secondary">{{ producto.categoria.nombre}}</span>
            <div>
                <span v-for="tag in producto.tags" class="badge bg-primary">{{ tag.nombre }}</span>
            </div>
            <p class="card-text">{{ producto.descripcion }}</p>

            <button class="btn btn-sm btn-warning mb-2" @click="verDetalle()">Detalle</button>
            
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
                this.$emit('submit')
            }catch(error){
                if(error.response.status === 401){
                    this.$router.push('/login')
                }
            }
        },

        cargarlink(link){
            return link ? 'http://localhost:8000/storage/productos/' + link : 'https://picsum.photos/100/100'
        },

        limpiar(){
            this.form.cantidad = 1
        },

        verDetalle(){
            this.$router.push("/producto-detalle/" + this.producto.id);
        }

    }

}

</script>