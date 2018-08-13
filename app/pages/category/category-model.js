import { Base } from "../../utils/base.js";
class Category extends Base{
  constructor(){
    super();
  }

  // 获取所有分类
  getCategoryType(callback) {
    var params = {
      url: 'category/all',
      sCallBack: function (res) {
        callback && callback(res);
      }
    };
    this.request(params);
  }
  // 获取某种分类的商品
  getProductByCategory(id, callback) {
    var params = {
      url: 'product/by_category?id=' + id,
      sCallBack: function (res) {
        callback && callback(res);
      }
    };
    this.request(params);
  }
}

export { Category }