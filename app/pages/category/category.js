// pages/category/category.js
import { Category } from 'category-model.js';
var category = new Category();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    categoryIndex: 0,
    transition: ["tanslate0", "tanslate1", "tanslate2", "tanslate3", "tanslate4","tanslate5"]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this._loadData();
  },

  _loadData:function(){
    category.getCategoryType((categoryData)=>{
      this.setData({
        categoryTypeArr: categoryData
      });
      category.getProductByCategory(categoryData[0].id, (data) => {
        var dataObj = {
          products:data,
          topImgUrl: categoryData[0].img.url,
          title: categoryData[0].name
        };
        this.setData({
          categoryProducts0: dataObj
        });
      });
    });
  },

  onProductsItemTap: function (event) {
    var id = category.getDataSet(event, 'id');
    wx.navigateTo({
      url: '../product/product?id=' + id,
    })
  },

  categoryItemTap:function(event){
    var id = category.getDataSet(event,"id");
    var index = category.getDataSet(event, "index");
    this.setData({
      categoryIndex: index
    });
    //如果数据是第一次加载
    if (!this.isLoadedData(index)){
      category.getProductByCategory(id, (data) => {
        var dataObj = {
          products: data,
          topImgUrl: this.data.categoryTypeArr[index].img.url,
          title: this.data.categoryTypeArr[index].name
        };
        var obj = {};
        obj["categoryProducts"+index] = dataObj;
        this.setData(obj);
      });
    }
  },

  isLoadedData(index){
    if (this.data["categoryProducts"+index]){
      return true;
    }
    return false;
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