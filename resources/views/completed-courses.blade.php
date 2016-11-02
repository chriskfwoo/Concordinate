@extends('layouts.header')

@section('content')

<div class="container">
      <div class="row" style="padding-top:30px;">
        <form role="form" action="../index.html" method="post" class="login-form">
        <div class="col-sm-3">
          <p style="text-align: center;padding-top:30px;">Year 1</p>
            <div class="row">
              <div class="col-sm-6">
                    <button type="button" class="btn btn-outline-danger" data-toggle="button">COMP232</button>
                    <button type="button" class="btn btn-outline-danger" data-toggle="button">COMP248</button>
                    <button type="button" class="btn btn-outline-danger" data-toggle="button">ENGR213</button>
                    <button type="button" class="btn btn-outline-danger" data-toggle="button">ENGR201</button>
                    <button type="button" class="btn btn-outline-danger" data-toggle="button">G. ELEC</button>
            </div>
                <div class="col-sm-6">

                    <button type="button" class="btn btn-outline-danger" data-toggle="button">COMP249</button>
                    <button type="button" class="btn btn-outline-danger" data-toggle="button">SOEN228</button>
                    <button type="button" class="btn btn-outline-danger" data-toggle="button">SOEN287</button>
                    <button type="button" class="btn btn-outline-danger" data-toggle="button">ENGR233</button>
                    <button type="button" class="btn btn-outline-danger" data-toggle="button">B. SCI</button>
            </div>

            </div>
        </div>

        <div class="col-sm-3">
          <p style="text-align: center; padding-top:30px;">Year 2</p>
            <div class="row">
              <div class="col-sm-6">
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">COMP352</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">COMP348</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">ENCS282</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">ENGR202</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">B. SCI</button>
            </div>
                <div class="col-sm-6">

                    <button type="button" class="btn btn-outline-danger" data-toggle="button">SOEN331</button>
                    <button type="button" class="btn btn-outline-danger" data-toggle="button">SOEN341</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">COMP346</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">ELEC275</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">ENGR371</button>
            </div>

            </div>
        </div>

        <div class="col-sm-3">
          <p style="text-align: center; padding-top:30px;">Year 3</p>
            <div class="row">
              <div class="col-sm-6">
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">COMP335</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">SOEN342</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">SOEN343</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">SOEN384</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">ENGR391</button>
            </div>
                <div class="col-sm-6">

                    <button type="button" class="btn btn-outline-danger"data-toggle="button">SOEN357</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">SOEN390</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">SOEN344</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">SOEN345</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">ELECTIVE</button>
            </div>

            </div>
        </div>

        <div class="col-sm-3">
          <p style="text-align: center; padding-top:30px;">Year 4</p>
            <div class="row">
              <div class="col-sm-6">
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">SOEN490</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">SOEN321</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">ENGR301</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">T. ELEC</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">T. ELEC</button>
            </div>
                <div class="col-sm-6">

                    <button type="button" class="btn btn-outline-danger"data-toggle="button">SOEN490</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">SOEN385</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">ENGR392</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">ELECTIVE</button>
                    <button type="button" class="btn btn-outline-danger"data-toggle="button">ELECTIVE</button>
            </div>

            </div>
        </div>
        <button type="submit" class="btn completed-btn">Set Complete Course</button>
        </form>
      </div>
    </div>
@endsection