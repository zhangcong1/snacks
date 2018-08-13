// pages/product/product.js
import { Product } from 'product-model.js';
var product = new Product();
import { Cart } from '../cart/cart-model.js';
var cart = new Cart();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    id: null,
    countsArr: [1,2,3,4,5,6,7,8,9,10],
    productCount: 1,
    currentTabsIndex: 0
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var id = options.id;
    this.data.id = id;
    this._loadData();
  },

  _loadData:function(){
    product.getDetailInfo(this.data.id,(data)=>{
      this.setData({
        cartTotalCount: cart.getCartToTalCounts(),
        product:data
      })
    })
  },

  bindPickerChange:function(event){
    var index = event.detail.value;
    var selectedCount = this.data.countsArr[index];
    this.setData({
      productCount: selectedCount
    });
  },

  onTabsItemTap:function(event){
    var index = product.getDataSet(event,'index');
    this.setData({
      currentTabsIndex: index
    });
  },

  onAddingToCartTap:function(event){
    this.addToCart();
    //var counts = this.data.cartTotalCount + this.data.productCount;
    this.setData({
      cartTotalCount: cart.getCartToTalCounts()
    });
  },

  addToCart:function(){
    var tempObj = {};
    var keys = ['id','name','main_img_url','price'];

    for (var key in this.data.product){
      if (keys.indexOf(key)>=0){
        tempObj[key] = this.data.product[key]
      }
    }
    
    cart.add(tempObj, this.data.productCount)
  },

  onCartTap:function(event){
    wx.switchTab({
      url: '/pages/cart/cart',
    })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
  
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
  
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
  
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})