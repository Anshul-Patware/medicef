@forelse ($riskmlog as $logs)
    @foreach ($logs->Action as $riskgrid)

    @php

        $unserializedData = unserialize($riskgrid->action);
 
        $actionValue = isset($unserializedData[0]) ? $unserializedData[0] : 'Not Available';
    @endphp

    <tr>
        <td>{{$loop->index+1}}</td>
        <td>{{ $logs->intiation_date ? \Carbon\Carbon::parse($logs->intiation_date)->format('d-M-Y') : 'Not Applicable' }}</td>

        <td>{{ $logs->division ? $logs->division->name : 'Not Available' }}/RM/{{ date('Y') }}/{{ str_pad($logs->record, 4, '0', STR_PAD_LEFT)}}</td>
        <td>{{$logs->short_description}}</td>
        <td>{{$logs->initiator ? $logs->initiator->name : 'Not Available'}}</td>
        <td>{{$logs->Initiator_Group}}</td>
        <td>{{$logs->division ? $logs->division->name : 'Not Available'}}</td>
        <td>{{$logs->source_of_risk}}</td>
        <td>{{$actionValue}}</td>
        <td>{{$logs->type}}</td>
        {{-- <td>{{$logs->Output_of_Risk_Management_Review}}find</td> --}}
        <td>{{$logs->due_date}}</td>
        <td>{{ $logs->due_date ? \Carbon\Carbon::parse($logs->due_date)->format('d-M-Y') : 'Not Applicable' }}</td>

        <td>{{$logs->risk_analysis_completed_on}}</td>
        <td>{{$logs->status}}</td>
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
