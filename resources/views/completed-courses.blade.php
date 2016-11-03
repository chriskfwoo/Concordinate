@extends('layouts.header')

@section('content')

<div class="container">
      <div class="row" style="padding-top:30px;">
        <form role="form" action="{{ url('/courses/completed/save') }}" method="get" class="login-form">
        <div class="col-sm-3">
          <p style="text-align: center;padding-top:30px;">Year 1</p>
            <div class="row">
              <div class="col-sm-6">
                    <input type="checkbox" id="COMP232" name="check_list[]" value = "COMP232"><label for="COMP232" >COMP232</label> 
                    <input type="checkbox" id="COMP248" name="check_list[]" value = "COMP248" checked="checked"><label for="COMP248">COMP248</label>
                    <input type="checkbox" id="ENGR213" name="check_list[]" value = "ENGR213"><label for="ENGR213">ENGR213</label>
                    <input type="checkbox" id="ENGR201" name="check_list[]" value = "ENGR201"><label for="ENGR201">ENGR201</label>
                    <input type="checkbox" id="G.ELEC" name="check_list[]" value = "G.ELEC"><label for="G.ELEC">G. ELEC</label>
                </div>
                <div class="col-sm-6">

                    <input type="checkbox" id="COMP249" name="check_list[]" value = "COMP249"><label for="COMP249">COMP249</label>
                    <input type="checkbox" id="SOEN228" name="check_list[]" value = "SOEN228"><label for="SOEN228">SOEN228</label>
                    <input type="checkbox" id="SOEN287" name="check_list[]" value = "SOEN287"><label for="SOEN287">SOEN287</label>
                    <input type="checkbox" id="ENGR233" name="check_list[]" value = "ENGR233"><label for="ENGR233">ENGR233</label>
                    <input type="checkbox" id="B.SCI" name="check_list[]" value = "B.SCI"><label for="B.SCI">B. SCI</label>
                    </div>

            </div>
        </div>

        <div class="col-sm-3">
          <p style="text-align: center; padding-top:30px;">Year 2</p>
            <div class="row">
              <div class="col-sm-6">
                    <input type="checkbox" id="COMP352" name="check_list[]" value = "COMP352"><label for="COMP352">COMP352</label>
                    <input type="checkbox" id="COMP348" name="check_list[]" value = "COMP348"><label for="COMP348">COMP348</label>
                    <input type="checkbox" id="ENCS282" name="check_list[]" value = "ENCS282"><label for="ENCS282">ENCS282</label>
                    <input type="checkbox" id="ENGR202" name="check_list[]" value = "ENGR202"><label for="ENGR202">ENGR202</label>
                    <input type="checkbox" id="B.SCI" name="check_list[]" value = "B.SCI"><label for="B.SCI">B. SCI</label>            
                </div>
                <div class="col-sm-6">

                    <input type="checkbox" id="SOEN331" name="check_list[]" value = "SOEN331"><label for="SOEN331">SOEN331</label>
                    <input type="checkbox" id="SOEN341" name="check_list[]" value = "SOEN341"><label for="SOEN341">SOEN341</label>
                    <input type="checkbox" id="COMP346" name="check_list[]" value = "COMP346"><label for="COMP346">COMP346</label>
                    <input type="checkbox" id="ELEC275" name="check_list[]" value = "ELEC275"><label for="ELEC275">ELEC275</label>
                    <input type="checkbox" id="ENGR371" name="check_list[]" value = "ENGR371"><label for="ENGR371">ENGR371</label>
            </div>

            </div>
        </div>

        <div class="col-sm-3">
          <p style="text-align: center; padding-top:30px;">Year 3</p>
            <div class="row">
              <div class="col-sm-6">
                    <input type="checkbox" id="COMP335" name="check_list[]" value = "COMP335"><label for="COMP335">COMP335</label>
                    <input type="checkbox" id="SOEN342" name="check_list[]" value = "SOEN342"><label for="SOEN342">SOEN342</label>
                    <input type="checkbox" id="SOEN343" name="check_list[]" value = "SOEN343"><label for="SOEN343">SOEN343</label>
                    <input type="checkbox" id="SOEN384" name="check_list[]" value = "SOEN384"><label for="SOEN384">SOEN384</label>
                    <input type="checkbox" id="ENGR391" name="check_list[]" value = "ENGR391"><label for="ENGR391">ENGR391</label>
            </div>
                <div class="col-sm-6">

                    <input type="checkbox" id="SOEN357" name="check_list[]" value = "SOEN357"><label for="SOEN357">SOEN357</label>
                    <input type="checkbox" id="SOEN390" name="check_list[]" value = "SOEN390"><label for="SOEN390">SOEN390</label>
                    <input type="checkbox" id="SOEN344" name="check_list[]" value = "SOEN344"><label for="SOEN344">SOEN344</label>
                    <input type="checkbox" id="SOEN345" name="check_list[]" value = "SOEN345"><label for="SOEN345">SOEN345</label>
                    <input type="checkbox" id="ELECTIVE" name="check_list[]" value = "ELECTIVE"><label for="ELECTIVE">ELECTIVE</label>
            </div>

            </div>
        </div>

        <div class="col-sm-3">
          <p style="text-align: center; padding-top:30px;">Year 4</p>
            <div class="row">
              <div class="col-sm-6">
                    <input type="checkbox" id="COMP232" name="check_list[]" value = "COMP232"><label for="COMP232">SOEN490</label>
                    <input type="checkbox" id="COMP232" name="check_list[]" value = "COMP232"><label for="COMP232">SOEN321</label>
                    <input type="checkbox" id="COMP232" name="check_list[]" value = "COMP232"><label for="COMP232">ENGR301</label>
                    <input type="checkbox" id="COMP232" name="check_list[]" value = "COMP232"><label for="COMP232">T. ELEC</label>
                    <input type="checkbox" id="COMP232" name="check_list[]" value = "COMP232"><label for="COMP232">T. ELEC</label>
            </div>
                <div class="col-sm-6">

                    <input type="checkbox" id="COMP232" name="check_list[]" value = "COMP232"><label for="COMP232">SOEN490</label>
                    <input type="checkbox" id="COMP232" name="check_list[]" value = "COMP232"><label for="COMP232">SOEN385</label>
                    <input type="checkbox" id="COMP232" name="check_list[]" value = "COMP232"><label for="COMP232">ENGR392</label>
                    <input type="checkbox" id="COMP232" name="check_list[]" value = "COMP232"><label for="COMP232">ELECTIVE</label>
                    <input type="checkbox" id="COMP232" name="check_list[]" value = "COMP232"><label for="COMP232">ELECTIVE</label>
            </div>

            </div>
        </div>
        <button type="submit" class="btn completed-btn">Set Complete Course</button>
        </form>
      </div>
    </div>
@endsection