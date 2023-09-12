<template>
    <div class="row">
        <div class="col-md-11 mx-auto">
            <div class="card">
                <div class="card-body">
                    <!-- Table -->
                    <ListarProductosComponent />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ListarProductosComponent from '../components/producto/ListarProductosComponent';
export default {

components: {
    ListarProductosComponent,
},

}

</script>