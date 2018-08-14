// pages/order/order.js
import { Cart } from '../cart/cart-model.js';
var cart = new Cart();
import { Order } from 'order-model.js';
var order = new Order();
import { Address } from '../../utils/address.js';
var address = new Address();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    id: -1
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    var productsArr;
    this.data.account = options.account;
    productsArr = cart.getCartDataFromLocal(true);
    this.setData({
      productsArr: productsArr,
      account: options.account,
      orderStatus: 0
    });

    address.getAddress((res)=>{
      that._bindAddressInfo(res);
    });
  },

  editAddress:function(event){
    var that = this;
    wx.chooseAddress({
      success:function(res){
        var addressInfo = {
          name: res.userName,
          mobile: res.telNumber,
          totalDetail: address.setAddressInfo(res)
        }
        that._bindAddressInfo(addressInfo);
        //保存地址
        address.submitAddress(res,(flag) => {
          if(!flag){
            that.showTips('操作提示','地址信息更新失败')
          }
        })
      }
    })
  },

  _bindAddressInfo:function(addressInfo){
    this.setData({
      addressInfo: addressInfo
    })
  },

  showTips:function(title, content, flag){
    wx.showModal({
      title: title,
      content: content,
      showCancel: false,
      success:function(res){
        if(flag){
          wx.switchTab({
            url: '/page/my/my',
          })
        }
      }
    })
  },

  pay:function(){
    if (!this.data.addressInfo){
      this.showTips('下单提示','请填写您的收货地址');
      return;
    }
    if(this.data.orderStatus == 0){
      this._firstTimePay();
    }else{
      this._oneMoresTimePay();
    }
  },

  _firstTimePay:function(){
    var orderInfo = [];
    var productInfo = this.data.productsArr;
    var order = new Order();
    for(let i=0;i<productInfo.length;i++){
      orderInfo.push({
        product_id: productInfo[i].id,
        counts: productInfo[i].counts
      })
    }
    var that = this;
    //支付分两步，第一步生成订单号，然后根据订单号支付
    order.doOrder(orderInfo,(data)=>{
      //订单生成成功
      if(data.pass){
        //更新订单状态
        var id = data.order_id;
        that.data.id = id;
        that.data.fromCartFlag = false;
        //开始支付
        that._execPay(id);
      }else{
        that._orderFail(data);
      }
    })
  },
  _execPay:function(id){
    var that = this;
    order.execPay(id,(statusCode)=>{
      if(statusCode != 0){
        //将已经下单的商品从购物车删除  
        that.deleteProducts();
        var flag = statusCode == 2;
        wx.navigateTo({
          url: '../pay-result/pay-result?id=' + id + '&flag=' + flag + '&from=order',
        })
      }
    })
  },
  deleteProducts:function(){
    var ids = [],
    arr = this.data.productsArr;
    for (let i=0;i<arr.length;i++){
      ids.push(arr[i].id);
    }
    cart.delete(ids);
  },
  _oneMoresTimePay:function(){

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
    if(this.data.id){
      var that = this;
      //下单后，支付成功或者失败后，点左上角返回时能够更新订单状态，所以放在onshow中
      var id = this.data.id;
      order.getOrderInfoById(id,(data)=>{
        that.setData({
          orderStatus: data.status,
          productsArr: data.snap_items,
          account: data.total_price,
          basicInfo:{
            orderTime: data.create_time,
            orderNo: data.order_no
          }
        });
        //快照地址
        var addressInfo = data.snap_address;
        addressInfo.totalDetail = address.setAddressInfo(addressInfo);
        that._bindAddressInfo(addressInfo);
      })
    }
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