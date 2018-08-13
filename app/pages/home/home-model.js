import {Base} from "../../utils/base.js"
class Home extends Base{
  constructor(){
    super();
  }

  getBannerData(id,callback){
    var params = {
      url: 'banner/'+id,
      sCallBack:function(res){
        callback && callback(res.item);
      }
    };
    this.request(params);
  }

  // 首页主题
  getThemeData(callback) {
    var params = {
      url: 'theme?ids=1,2,3',
      sCallBack: function (res) {
        callback && callback(res);
      }
    };
    this.request(params);
  }

  getProductsData(callback) {
    var params = {
      url: 'product/recent',
      sCallBack: function (res) {
        callback && callback(res);
      }
    };
    this.request(params);
  }
}

export {Home}