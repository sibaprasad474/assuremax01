<fieldset>
    <legend>Add Insurance</legend>

    <div class="form-group">
        <label for="full_name">Full Name *</label>
        <input type="text" name="full_name" class="form-control" required id="full_name">
    </div>

    <div class="form-group">
        <label for="email">Email *</label>
        <input type="email" name="email" class="form-control" required id="email">
    </div>

    <div class="form-group">
        <label for="phone">Phone *</label>
        <input type="text" name="phone" class="form-control" required id="phone">
    </div>

    <div class="form-group">
        <label for="pan_no">PAN Number *</label>
        <input type="text" name="pan_no" class="form-control" required id="pan_no">
    </div>

    <div class="form-group">
        <label for="aadhaar_no">Aadhaar Number *</label>
        <input type="text" name="aadhaar_no" class="form-control" required id="aadhaar_no">
    </div>

    <div class="form-group">
        <label for="dob">Date of Birth *</label>
        <input type="date" name="dob" class="form-control" required id="dob">
    </div>

    <!-- Gender Field -->
    <div class="form-group">
        <label>Gender *</label><br>
        <label for="gender_male">
            <input type="radio" name="gender" value="male" id="gender_male" required> Male
        </label>
        <label for="gender_female">
            <input type="radio" name="gender" value="female" id="gender_female" required> Female
        </label>
        <label for="gender_other">
            <input type="radio" name="gender" value="other" id="gender_other"> Other
        </label>
    </div>

    <!-- Insurance Details -->
    <div class="form-group">
        <label for="insurance_type">Type of Insurance *</label>
        <select name="insurance_type" class="form-control" required id="insurance_type">
            <option value="" disabled selected>Select insurance type</option>
            <option value="health">Health Insurance</option>
            <option value="life">Life Insurance</option>
            <option value="vehicle">Vehicle Insurance</option>
            <option value="home">Home Insurance</option>
            <option value="travel">Travel Insurance</option>
            <option value="business">Business Insurance</option>
        </select>
    </div>

    <div class="form-group">
        <label for="policy_number">Policy Number *</label>
        <input type="text" name="policy_number" class="form-control" required id="policy_number">
    </div>

    <div class="form-group">
        <label for="coverage_amount">Coverage Amount *</label>
        <input type="number" name="coverage_amount" class="form-control" required id="coverage_amount" min="0"
            step="0.01">
    </div>

    <div class="form-group">
        <label for="premium_amount">Premium Amount *</label>
        <input type="number" name="premium_amount" class="form-control" required id="premium_amount" min="0"
            step="0.01">
    </div>

    <div class="form-group">
        <label for="policy_start_date">Policy Start Date</label>
        <input type="date" name="policy_start_date" id="policy_start_date" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="policy_end_date">Policy End Date</label>
        <input type="date" name="policy_end_date" id="policy_end_date" class="form-control" required>
    </div>

    <!-- Submit Button -->
    <div class="form-group text-center">
        <button type="submit" class="btn btn-warning">Save <span class="glyphicon glyphicon-send"></span></button>
    </div>
</fieldset>