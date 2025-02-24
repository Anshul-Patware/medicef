@php
    $serialNumber = 1;
@endphp

@forelse ($oots as $ootlog)
    @php
        $productDetails = $ootlog->ProductGridOot;
    @endphp
    @foreach ($productDetails['data'] as $data)
        <tr>
            <td>{{ $serialNumber++ }}</td>
            <td>{{ \Carbon\Carbon::parse($ootlog->intiation_date)->format('j-M-Y') }}</td>
            <td>{{ $ootlog->division ? $ootlog->division->name : 'Na' }}/OOT/{{ date('Y') }}/{{ $ootlog->record_number }}</td>
            <td>{{ $ootlog->short_description }}</td>
            <td>
                @foreach ($oosmicro as $micro)
                    {{ $micro->source_document_type_gi ? $micro->source_document_type_gi : 'Not Available' }}
                @endforeach
            </td>
            <td>{{ $data['item_product_code'] }}</td>
            <td>{{ $data['lot_batch_no'] }}</td>
            <td>{{ \Carbon\Carbon::parse($ootlog->due_date)->format('j-M-Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($ootlog->Final_Approval_on)->format('j-M-Y') }}</td>
            <td>{{ $ootlog->status }}</td>
        </tr>
    @endforeach
@empty
<tr>
    <td colspan="12" class="text-center">
    <div class="alert my-3" 
         style="background: linear-gradient(135deg, #e3f2fd, #ffffff); 
                border: 1px solid rgb(236,160,53); 
                border-radius: 16px; 
                padding: 30px; 
                box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);">
        <!-- Pharma Icon -->
        <div style="font-size: 60px; margin-bottom: 15px; display: inline-block; position: relative; padding: 20px; border-radius: 15px; background: linear-gradient(135deg, #eca035, #66bb6a); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: all 0.3s ease; width: 100px;">
  <i class="fas fa-file-alt" style="color: white;"></i>
</div>



        <!-- Main Message -->
        <div style="font-size: 24px; font-weight: bold; color: #eca035; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);">
            No Data Available
        </div>
        <!-- Sub-Message -->
        <p style="margin-top: 10px; font-size: 16px; color: #616161;">
            We couldn't find any records. Please check your filters or try again later.
        </p>
        <!-- Pharma Logo (Optional) -->
        <!-- <div style="margin-top: 20px;">
            <img src="path/to/pharma-logo.png" alt="Pharma Logo" 
                 style="width: 80px; height: auto; opacity: 0.8;">
        </div> -->
    </div>
</td>

    </tr>
@endforelse