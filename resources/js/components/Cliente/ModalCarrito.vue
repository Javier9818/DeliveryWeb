<template>
    <div>
        <a href="#" class="navbar__action-btn navbar__action-btn-cart">
                <i class="icon-cart"></i><span class="cart__label">{{productos.length}}</span>
        </a>
        <div class="cart-popup main-menu">
            <h6 class="text-center">Carrito de compras</h6>
            <hr>
            <ul class="list-unstyled  " style=" overflow: auto height:250pxword-wrap: break-word width:110%">
                <li class="cart-item" v-for="(item, index) of productos" :key="index">
                <div class="cart__item-img"><img :src="'/storage/imgproductos/'+item.foto" alt="Product"></div>
                <div class="cart__item-content">
                    <h6 class="cart__item-title" style="color:black">{{item.nombre}} (Cant.{{item.cant}})</h6>
                    <div class="cart__item-detail">S/. {{item.precio}}</div>
                    <i  @click="eliminar(index)" class="cart__item-delete">&times;</i>
                </div><!-- /.cart-item-content -->
                </li>
            </ul>
            <div class="cart-subtotal">
                <span>Total:</span>
                <span class="color-theme">S/ {{calcularTotal}}</span>
            </div><!-- /.cart-subtotal -->
            <div class="cart-action d-flex justify-content-center">
                <a href="/micarrito" class="btn btn__primary" @click="clickComponent('/micarrito')">Ir a carrito</a>
            </div><!-- /.cart-action -->
        </div>
    </div>
</template>

<script>

    import EventBus from '../../event-bus'
    export default {
        data(){
            return {
                productos: [
                ],
                total: 0
            }
        },
        methods:{
            eliminar: function(index){
                removeFromCartEvent(this.productos[index])
                this.productos.splice(index,1)
                let cockie=this.productos
                this.$cookies.set('carrito',JSON.stringify(cockie))                
                EventBus.$emit('EliminarenModal', true)
            },
            recarga: function () {
                let cockie=JSON.parse(this.$cookies.get('carrito'))
                if (cockie==null) {
                    cockie=[]
                }
                this.productos=cockie
            }
        },
        computed:{

            calcularTotal(){
                this.total = 0
                var item
                this.productos.forEach(element => {
                     this.total = this.total + (element.precio*element.cant)
                })
                return this.total
            }
        },
        mounted() {
            this.recarga()

           
        },
        created: function () {
            EventBus.$on('i-got-clicked', function(producto)  {
            let cockie=JSON.parse(this.$cookies.get('carrito'))
            if (cockie==null) {
                cockie=[]
            }
            let index=cockie.map(
                function (item) {
                    return item.id
                }
            ).indexOf(producto.id)
            console.log(index)
            if (index>=0) {
                cockie[index].cant+=producto.cant
            }else{
                cockie.push(producto)
            }
            this.productos=cockie
            this.$cookies.set('carrito',JSON.stringify(cockie))
            }.bind(this))
            EventBus.$on('elimiarEnCart', function(boolean)  {
                if(boolean)
                    this.recarga()
            }.bind(this))
            EventBus.$on('ActualizaEnCart', function(boolean)  {
                if(boolean)
                    this.recarga()
            }.bind(this))
        }
    }
</script>
