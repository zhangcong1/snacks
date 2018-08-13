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