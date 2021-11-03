<!-- Subject Form Input -->
<div class="form-group mb-3">
    <label class="form-label">Subject</label>
    <input type="text" class="form-control" name="subject" placeholder="Subject"
           value="{{ old('subject') }}" required>
</div>

<!-- Message Form Input -->
<div class="form-group mb-3">
    <label class="form-label">Message</label>
    <textarea name="message" class="form-control" required>{{ old('message') }}</textarea>
</div>

@if($users->count() > 0)
    <div class="form-group mb-3">
        <label class="form-label">Choose Participants</label>
        <select id="recipients_select" name="recipients_select" multiple>
        @foreach($users as $user)
            <option value="{{ $user->id }}">{!!$user->name!!}</option>
        @endforeach
        </select>
        <div class="d-none">
        @foreach($users as $user)
            <label title="{{ $user->name }}">
                <input type="checkbox" class="chk_recipients" name="recipients[]" value="{{ $user->id }}">
                {!!$user->name!!}
            </label>
        @endforeach
        </div>
    </div>
@endif