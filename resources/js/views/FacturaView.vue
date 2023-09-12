<template>

<div class="card">
    <div class="card-body">
        <table class="table table-striped mb-2">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">producto</th>
                    <th scope="col">precio_unitario</th>
                    <th scope="col">cantidad</th>
                    <th scope="col">total</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="detalle in orden.detalles">
                    <th scope="row">{{ detalle.producto.id }}</th>
                    <td>{{ detalle.producto.nombre }}</td>
                    <td>${{ detalle.producto.precio }}</td>
                    <td>{{ detalle.cantidad }}</td>
                    <td>${{ detalle.cantidad * detalle.producto.precio }}</td>
                </tr>
            </tbody>
        </table>

        <h2 class="text-center">Total : ${{ total }}</h2>

        <h3 class="text-center">Completa la información para finalizar la compra</h3>

        <div class="alert alert-danger" role="alert" v-if="errores.length">
            <p v-for="error in errores">{{ error }}</p>
        </div> 

        <form @submit.prevent="submit()">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" class="form-control" v-model="form.nombre_completo" id="nombre" placeholder="Nombre ...">
            </div>
            <div class="mb-3">
                <label for="documento" class="form-label">Documento</label>
                <input type="text" class="form-control" v-model="form.documento" id="documento" placeholder="documento ...">
            </div>
            <div class="mb-3">
                <label for="tarjeta de credito" class="form-label">Tarjeta de credito</label>
                <input type="text" class="form-control" v-model="form.tarjeta_credito" id="tarjeta de credito" placeholder="tarjeta de credito ...">
            </div>
            <div class="mb-3">
                <label for="cvc" class="form-label">CVC</label>
                <input type="text" class="form-control" v-model="form.CVC" id="cvc" placeholder="cvc ...">
            </div>
            <div class="mb-3">
                <label for="fecha_vencimiento" class="form-label">Fecha vencimiendo de la tarjeta</label>
                <input type="date" class="form-control" v-model="form.fecha_vencimiento_tarjeta" id="fecha_vencimiento" placeholder="fecha_vencimiento ...">
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-success">Finalizar</button>
                <button type="button" class="btn btn-danger">Cancelar</button>
            </div>
        </form>

    </div>
</div>

</template>
<script>

export default {

    data(){
        return {
            orden: null,
            form: {
                nombre_completo: null,
                documento: null,
                tarjeta_credito: null,
                CVC: null,
                fecha_vencimiento_tarjeta: null,
            },
            errores: []
        }
    },

    created(){
        this.miOrden()
    },

    computed:{
        total(){
            return this.orden.detalles.reduce((acum, current) => {
                return acum + (current.producto.precio * current.cantidad)
            }, 0)
        }
    },

    methods: {

        async submit(){
            try{
                const response = await this.axios.post('/factura/crear', this.form)
                this.limpiar();
                this.$router.push("/")
            }catch(error){
                console.error(error.response)
                this.errores = Object.values(error.response.data).reduce((accumulator, currentArray) => {
                    return accumulator.concat(currentArray);
                }, []);
            }
        },

        async miOrden(){
            try {
                const response = await this.axios.get('/orden/mi-orden')
                this.orden = response.data
            }catch (error) {
                console.log(error.response)
            }
        },

        limpiar(){
            this.form.nombre_completo = null
            this.form.documento = null
            this.form.tarjeta_credito = null
            this.form.CVC = null
            this.form.fecha_vencimiento_tarjeta = null
            this.errores = []
        }
    
    }

}

</script>