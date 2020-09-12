<div class="panel panel-default" >
            <div class="panel-heading">
                   <p> خيارات البحث </p> 
            </div>
            <div class="panel-body" >
               <div class="container-fluid" >
                <form action="search.php"  method="POST">
                    <div class=" col-xs-12 col-sm-12 col-md-6 col-md-6">
                        <label > الحد الادني </label>
                        <select name="minAage" class="form-control" >
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                        </select>
                        <label > الحد الاقصى </label>
                        <select name="maxAage" class="form-control" >
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                        </select>
                    </div> 
                    <div class=" col-xs-12 col-sm-12 col-md-6 col-md-6">
                        <label > المدينة </label>
                        <select name="town" class="form-control">
                            <option value="0" >- ... -</option>
                            <option value="cairo" > القاهرة </option>
                            <option value="Giza" > الجيزة </option>
                            <option value="ismailia" > الاسماعيلة </option>
                            <option value="qalibia" > القليوبية </option>
                        </select>
                        <label > الحالة الإجتماعية </label>
                        <select name="gender" class="form-control">
                            <option value="0" >- ... -</option>
                            <option value="1" > اعذب </option>
                            <option value="2" > متزوج </option>
                            <option value="3" > خاطب / مخطوبة </option>
                        </select>
                    </div>
                    <div class="col-sm-12" ><br>
                        <button type="submit"  class="btn btn-success btn-block" ><i class="fa fa-search" ></i> بحث </button>
                    </div>
                </form> 
               </div>
            </div> 
</div>