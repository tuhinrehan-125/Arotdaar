export const state = () => ({
  cartProducts: [],
  commission: 0,
  advancepayout: 0,
  advance: 0,
})
export const getters = {
  getCartProducts(state) {
    return state.cartProducts;
  },
  commission(state) {
    return state.commission;
  },
  advancepayout(state) {
    return state.advancepayout;
  },
  grandTotal(state, getters) {
    let price = getters.totalPrice;
    let advancepayout = state.advancepayout
    let total = price - advancepayout;
    return total;
  },
  totalPrice(state, getters) {
    let price = getters.subTotalPrice;
    let commission = state.commission;
    let percentage = price * commission / 100;
    let total = price - percentage;
    return total;
  },

  subTotalPrice(state, getters) {
    let items = getters.getCartProducts
    let price = 0;

    if (items && items.length) {
      items.forEach(item => {
        price += Number(item.total);
      });
    }
    return price;

  }

}
export const mutations = {
  SET_CART_PRODUCTS(state, payload) {
    state.cartProducts = payload;
  },
  SET_ADVANCE(state, payload) {
    state.advance = payload;
  },
  SET_ADVANCE_PAYOUT(state, payload) {
    state.advancepayout = payload;
  },
  ADD_TO_CART(state, payload) {
    let items = state.cartProducts;

    if (items) {
      items.push(payload);
    } else {
      state.cartProducts = [payload];
    }
  },

  REMOVE_PRODUCT(state, payload) {
    let items = state.cartProducts;
    if (items) {
      state.cartProducts = payload;
      // let product = items.find(product => {
      //   return product.id == payload.id;
      // });

      // if (product) {
      //   let index = items.indexOf(product);
      //   items = items.splice(index, 1);
      // }
    }
  },
  SET_COMMISSION(state, payload) {
    state.commission = payload
  },

}

export const actions = {
  addToCart({ commit, getters }, { product, product_id, price, quantity, customer_id, customer_name, ptype, qtymethod }) {
    let item = {
      product: product,
      product_id: product_id,
      price: price ? price / 40 : 0,
      qty: quantity ? quantity : 1,
      total: (price / 40) * quantity,
      customer_id: customer_id,
      customer_name: customer_name,
      ptype: ptype,
      qtymethod: qtymethod,
    }
    commit('ADD_TO_CART', item);
  },
  updateCartItem({ commit, getters }, payload) {
    let cartProducts = getters.getCartProducts
    if (payload.type == 'pricechange') {
      if (cartProducts) {
        if(payload.price>0){
          let index = payload.index
        cartProducts[index].price = payload.price
        cartProducts[index].total = (payload.price / 40) * cartProducts[index].qty
        commit('SET_CART_PRODUCTS', cartProducts);
        }

      }
    }
    if (payload.type == 'qtyMchnage') {
      if (cartProducts) {
        let index = payload.index
        if (payload.qtymethod === 'Thika') {
          cartProducts[index].qtymethod = payload.qtymethod
          cartProducts[index].total = 1 * cartProducts[index].price
          commit('SET_CART_PRODUCTS', cartProducts);
        } else if (payload.qtymethod === 'KG') {
          cartProducts[index].total = (cartProducts[index].price / 40) * cartProducts[index].qty
          cartProducts[index].qtymethod = payload.qtymethod
          commit('SET_CART_PRODUCTS', cartProducts);
        }
      }
    }
    if (payload.type == 'qtychange') {
      if (cartProducts) {
        let index = payload.index
        cartProducts[index].qty = payload.qty
        cartProducts[index].total = payload.qty * (cartProducts[index].price / 40)
        commit('SET_CART_PRODUCTS', cartProducts);
      }
    }
    if (payload.type == 'customerchange') {
      if (cartProducts) {
        let index = payload.index
        cartProducts[index].customer_id = payload.customer_id
        cartProducts[index].customer_name = payload.customer_name
        commit('SET_CART_PRODUCTS', cartProducts);
      }
    }
    if (payload.type == 'paymentChange') {
      if (cartProducts) {
        let index = payload.index
        cartProducts[index].ptype = payload.ptype
        commit('SET_CART_PRODUCTS', cartProducts);
      }
    }
  },
  updatePrice({ commit, getters }, { product, price, index }) {
    let cartProducts = getters.getCartProducts
    if (cartProducts) {
      cartProducts[index].price = price / 40
      cartProducts[index].total = (price / 40) * cartProducts[index].qty
      commit('SET_CART_PRODUCTS', cartProducts);
    }

  },
  removeCartItem({ commit, getters }, { product, index }) {
    let cartProducts = getters.getCartProducts
    if (cartProducts) {
      cartProducts.splice(index, 1);
      commit('REMOVE_PRODUCT', cartProducts);
    }
  }

}


