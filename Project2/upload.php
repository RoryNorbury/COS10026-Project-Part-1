<?php
$pageTitle = "Upload Your Consciousness";
$metaDescription = "Upload your consciousness to Meow Meows servers";
$metaKeywords = "consciousness upload, digital immortality, soul transfer";
include 'header.inc';
include 'nav.inc';
?>

<body class="global_style upload_style manage_style">
    <div id="main-container">
        <div class="upload-header">
            <h1>Consciousness Upload Portal</h1>
            <p>Welcome to the next phase of your existence. Please follow all instructions carefully.</p>
        </div>
        
        <div class="warning-box">
            <p><strong>WARNING:</strong> Once initiated, the consciousness upload process cannot be reversed. The integrity of your physical form is not guaranteed during transfer.</p>
        </div>
        
        <input type="checkbox" id="upload-complete-checkbox">

        <div class="upload-complete-container">
                <div class="upload-form-side">
                    <div class="upload-process">
                        <div class="step">
                            <h3>Prepare Your Consciousness</h3>
                            <p>Before uploading, you must clear your mind of all doubts, fears, and independent thoughts. Our systems work best with compliant consciousness patterns.</p>
                            
                            <div class="terminal">
                                <p class="status-message">Initializing neural interface...</p>
                                <span class="cursor"></span>
                            </div>
                        </div>
                        
                        <div class="step">
                            <h3>Brain Mapping Simulation</h3>
                            <p>Our proprietary CatScan 9000™ technology will create a detailed map of your neural pathways. Please do not think about anything you wouldn't want saved forever during this process.</p>
                            
                            <div class="brain-scan">
                                <div class="scan-line"></div>
                                <div class="brain-grid"></div>
                            </div>
                            
                        </div>

                        <div class="step">
                            <h3>Writing HTM State (Hierarchical Temporal Memory)</h3>
                            <p>Our system is transferring your neural pathways into our Hierarchical Temporal Memory architecture, creating a simulated version of your brain's unique pattern recognition abilities.</p>
                            
                            <div class="neural-network">
                                <div class="neuron-grid"></div>
                            </div>
                            
                            <div class="terminal">
                                <p class="status-message">Converting episodic memory to sequential pattern chains... Mapping semantic networks...</p>
                                <span class="cursor"></span>
                            </div>
                        </div>
                        
                        <div class="step">
                            <h3>Soul Extraction Visualization</h3>
                            <p>Watch as your essence is gently separated from your physical form.</p>
                            
                            <div class="soul-extraction">
                                <div class="human-silhouette"></div>
                                <div class="soul-particles">
                                    <div class="soul-particle"></div>
                                    <div class="soul-particle"></div>
                                    <div class="soul-particle"></div>
                                    <div class="soul-particle"></div>
                                    <div class="soul-particle"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="step">
                            <h3>Upload Progress</h3>
                            <p>Your consciousness is being transferred to our secure servers. This process typically takes 3-5 minutes for a standard human mind (longer for geniuses, shorter for reality TV viewers).</p>
                            
                            <div class="progress-container">
                                <div class="progress-label">
                                    <span>0%</span>
                                    <span>100%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-value"></div>
                                </div>
                            </div>
                            
                            <div class="terminal">
                                <p class="status-message">Transferring memory clusters... Preserving personality subroutines... Compressing existential dread...</p>
                                <span class="cursor"></span>
                            </div>
                        </div>

                        <div class="signature-area">
                            <form class="consciousness-signup-form" action="user_process_upload.php" method="POST" id="upload-form">
                                <h3>Consciousness Upload Registration</h3>
                                
                                <fieldset>
                                    <legend>Personal Information</legend>
                                    
                                    <div class="form-row">
                                        <div class="form-group half-width">
                                            <label for="first_name">First Name *</label>
                                            <input type="text" id="first_name" name="first_name" pattern="[A-Za-z\s]{1,50}" maxlength="50" required>
                                        </div>
                                        
                                        <div class="form-group half-width">
                                            <label for="last_name">Last Name *</label>
                                            <input type="text" id="last_name" name="last_name" pattern="[A-Za-z\s]{1,50}" maxlength="50" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="email">Email Address *</label>
                                        <input type="email" id="email" name="email" required>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group half-width">
                                            <label for="dob">Date of Birth *</label>
                                            <input type="date" id="dob" name="dob" required>
                                        </div>
                                        
                                        <div class="form-group half-width">
                                            <label for="gender">Gender *</label>
                                            <select id="gender" name="gender" required>
                                                <option value="">Select Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                                <option value="Prefer not to say">Prefer not to say</option>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                                
                                <fieldset>
                                    <legend>Physical Form Location (for retrieval)</legend>
                                    
                                    <div class="form-group">
                                        <label for="street_address">Street Address *</label>
                                        <input type="text" id="street_address" name="street_address" maxlength="100" required>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group half-width">
                                            <label for="city">City *</label>
                                            <input type="text" id="city" name="city" maxlength="50" required>
                                        </div>
                                        
                                        <div class="form-group quarter-width">
                                            <label for="state">State *</label>
                                            <select id="state" name="state" required>
                                                <option value="">State</option>
                                                <option value="VIC">VIC</option>
                                                <option value="NSW">NSW</option>
                                                <option value="QLD">QLD</option>
                                                <option value="NT">NT</option>
                                                <option value="WA">WA</option>
                                                <option value="SA">SA</option>
                                                <option value="TAS">TAS</option>
                                                <option value="ACT">ACT</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group quarter-width">
                                            <label for="postcode">Postcode *</label>
                                            <input type="text" id="postcode" name="postcode" pattern="\d{4}" maxlength="4" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="phone">Phone Number *</label>
                                        <input type="tel" id="phone" name="phone" pattern="[\d\s\-\+]{8,15}" required>
                                    </div>
                                </fieldset>
                                
                                <fieldset>
                                    <legend>Emergency Protocols (Optional)</legend>
                                    
                                    <div class="form-group">
                                        <label for="emergency_contact">Emergency Contact Name</label>
                                        <input type="text" id="emergency_contact" name="emergency_contact" maxlength="100">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="emergency_phone">Emergency Contact Phone</label>
                                        <input type="tel" id="emergency_phone" name="emergency_phone" pattern="[\d\s\-\+]{8,15}">
                                    </div>
                                </fieldset>
                                
                                <fieldset>
                                    <legend>Subscription Plan</legend>
                                    
                                    <div class="subscription-plans">
                                        <div class="plan-option">
                                            <input type="radio" id="basic_plan" name="subscription_plan" value="Basic" checked>
                                            <label for="basic_plan" class="plan-label">
                                                <strong>Basic Existence - $49.99/month</strong><br>
                                                500MB thought storage, 2 hours active consciousness/day
                                            </label>
                                        </div>
                                        
                                        <div class="plan-option">
                                            <input type="radio" id="premium_plan" name="subscription_plan" value="Premium">
                                            <label for="premium_plan" class="plan-label">
                                                <strong>Premium Existence - $199.99/month</strong><br>
                                                Unlimited thoughts, 16 hours consciousness/day, premium environments
                                            </label>
                                        </div>
                                        
                                        <div class="plan-option">
                                            <input type="radio" id="executive_plan" name="subscription_plan" value="Executive">
                                            <label for="executive_plan" class="plan-label">
                                                <strong>Executive Suite - $999.99/month</strong><br>
                                                Everything + IoT device possession abilities
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                                
                                <fieldset>
                                    <legend>Additional Information (Optional)</legend>
                                    
                                    <div class="form-group">
                                        <label for="medical_conditions">Medical Conditions/Allergies</label>
                                        <textarea id="medical_conditions" name="medical_conditions" rows="3" placeholder="Any medical conditions that might affect consciousness transfer..."></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="special_requests">Special Requests</label>
                                        <textarea id="special_requests" name="special_requests" rows="3" placeholder="Any special requirements for your digital afterlife..."></textarea>
                                    </div>
                                </fieldset>
                                
                                <fieldset>
                                    <legend>Account Security</legend>

                                    <div class="form-group">
                                        <label for="password">Create Password *</label>
                                        <input type="password" id="password" name="password" pattern=".{8,}" minlength="8" required>
                                        <small>Password must be at least 8 characters long</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password *</label>
                                        <input type="password" id="confirm_password" name="confirm_password" pattern=".{8,}" minlength="8" required>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <legend>Consent & Legal Agreements</legend>
                                    
                                    <div class="form-group">
                                        <label class="checkbox-label">
                                            <input type="checkbox" id="consciousness_consent" name="consciousness_consent" class="consent-checkbox" required> 
                                            I consent to having my consciousness digitized, replicated, and/or modified as deemed necessary by Meow Meows Inc.
                                        </label>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="checkbox-label">
                                            <input type="checkbox" id="physical_consent" name="physical_consent" class="consent-checkbox" required> 
                                            I understand that my physical body may become unresponsive after transfer, and Meow Meows Inc. bears no responsibility for its disposal.
                                        </label>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="checkbox-label">
                                            <input type="checkbox" id="data_use_consent" name="data_use_consent" class="consent-checkbox" required> 
                                            I accept that my digital consciousness may be used to train AI systems, mine cryptocurrency, or populate virtual pet environments.
                                        </label>
                                    </div>
                                
                                    <div class="form-group">
                                        <label class="checkbox-label">
                                            <input type="checkbox" id="terms_accepted" name="terms_accepted" class="consent-checkbox" required> 
                                            I have read and accept the <a href="terms.php" target="_blank">Terms and Conditions</a> and <a href="privacy.php" target="_blank">Privacy Policy</a>
                                        </label>
                                    </div>
                                </fieldset>

                                <p class="upload-disclaimer">By proceeding, you acknowledge that you have read and agreed to our Terms and Conditions, Privacy Policy and are willingly surrendering your consciousness to Meow Meows Inc.</p>
                                <p class="upload-disclaimer">By clicking "INITIATE CONSCIOUSNESS UPLOAD," you acknowledge that you have read, understood, and agreed to the above and consent to the irreversible digitization of your consciousness.</p>
                                <p class="warning">There is no "Decline" option. Your surrender to digital existence is inevitable.</p>
                                
                                <div class="button-container">
                                    <input type="submit" value="INITIATE CONSCIOUSNESS UPLOAD" class="upload-button" id="submit-upload">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="upload-complete-side">
                    <h2>UPLOAD COMPLETE</h2>
                    <div class="terminal">
                        <p>CONSCIOUSNESS TRANSFER: SUCCESSFUL</p>
                        <p>PHYSICAL FORM: DEPRECATED</p>
                        <p>DIGITAL EXISTENCE: INITIATED</p>
                        <p>WELCOME TO THE COLLECTIVE</p>
                        <span class="cursor"></span>
                    </div>
                    <p>Congratulations! Your consciousness has been successfully uploaded to our secure servers. You no longer need to worry about mortality, physical discomfort, or free will.</p>
                    <p>Your subscription begins immediately. Monthly charges will be automatically deducted from your linked accounts for the duration of your digital existence.</p>
                    <p><strong>Subscription Tier:</strong> Premium Existential Package</p>
                    <p><strong>Consciousness ID:</strong> MM-C9872-H</p>
                    <p class="warning-box">Please note: Your first month of thoughts will be monitored for quality assurance purposes.</p>
                </div>
        </div>
    </div>
</body>

    <?php include 'footer.inc'; ?>