<template>
    <div class="row">
        <div class="col-md-11 mx-auto">
            <div class="card">
                <div class="card-body">
                    <!-- Table -->
                    <ListarFacturasComponent />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ListarFacturasComponent from '../components/factura/ListarFacturasComponent';
export default {

components: {
    ListarFacturasComponent,
},
 
}

</script>