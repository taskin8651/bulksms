<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template Editor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --accent: #7209b7;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4cc9f0;
            --border-radius: 12px;
            --box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }
        
        body {
            background-color: #f5f7fb;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 2rem;
        }
        
        .email-template-card {
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: none;
            overflow: hidden;
            margin-top: 2rem;
        }
        
        .card-header {
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            padding: 1.5rem;
            border-bottom: none;
        }
        
        .template-title {
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            transition: var(--transition);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #2d3748;
        }
        
        .editor-toolbar {
            background: #f8f9fa;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            border: 2px solid #e2e8f0;
            border-bottom: none;
            padding: 0.5rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .editor-content {
            min-height: 300px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            border: 2px solid #e2e8f0;
            padding: 1rem;
            background: white;
        }
        
        .btn-primary {
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: var(--transition);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-outline-secondary {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: var(--transition);
        }
        
        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            border-color: #cbd5e0;
        }
        
        .template-preview {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 1.5rem;
            height: 100%;
        }
        
        .preview-header {
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }
        
        .token-badge {
            background-color: #edf2ff;
            color: var(--primary);
            padding: 0.35rem 0.65rem;
            border-radius: 6px;
            font-size: 0.85rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            display: inline-block;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .token-badge:hover {
            background-color: #dbe4ff;
        }
        
        .editor-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }
        
        .action-btn {
            background: #f8f9fa;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
        }
        
        .action-btn:hover {
            background: #edf2f7;
        }
        
        .ai-assistant {
            background: linear-gradient(120deg, #ff6b6b, #ff9e7d);
            color: white;
            border: none;
        }
        
        .ai-assistant:hover {
            background: linear-gradient(120deg, #ff5252, #ff8a65);
        }
        
        .ai-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .ai-modal-content {
            background: white;
            border-radius: var(--border-radius);
            width: 90%;
            max-width: 600px;
            box-shadow: var(--box-shadow);
            overflow: hidden;
        }
        
        .ai-modal-header {
            background: linear-gradient(120deg, var(--accent), #b5179e);
            color: white;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .ai-modal-body {
            padding: 1.5rem;
        }
        
        .ai-option {
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .ai-option:hover {
            border-color: var(--accent);
            background: #f9f0ff;
        }
        
        .ai-option h5 {
            color: var(--accent);
            margin-bottom: 0.5rem;
        }
        
        .ai-option p {
            color: #6c757d;
            margin: 0;
        }
        
        .ai-generating {
            display: none;
            text-align: center;
            padding: 2rem;
        }
        
        .ai-generating .spinner {
            width: 3rem;
            height: 3rem;
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--accent);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .alert {
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: none;
        }
        
        @media (max-width: 768px) {
            .template-preview {
                margin-top: 2rem;
            }
        }
        
        .hidden-body-field {
            margin-top: 1rem;
        }
        
        .data-preview {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
            font-family: monospace;
            font-size: 0.9rem;
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Success/Error Messages -->
                <div id="messageAlert" class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <span id="messageText"></span>
                </div>
                
                <div class="email-template-card card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h1 class="template-title text-white"><i class="fas fa-envelope-open-text me-2"></i>Create Email Template</h1>
                            <a href="{{ route('admin.email-templates.index') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Back to Templates
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body p-4">
                        <form id="emailTemplateForm" method="POST" action="{{ route('admin.email-templates.store') }}"  >
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-4">
                                        <label for="template_name" class="form-label">Template Name</label>
                                        <input type="text" class="form-control" id="template_name" name="template_name" placeholder="Enter template name" required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="subject" class="form-label">Email Subject</label>
                                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter email subject" required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label">Email Content</label>
                                        <div class="editor-toolbar">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-outline-secondary" data-command="bold"><i class="fas fa-bold"></i></button>
                                                <button type="button" class="btn btn-outline-secondary" data-command="italic"><i class="fas fa-italic"></i></button>
                                                <button type="button" class="btn btn-outline-secondary" data-command="underline"><i class="fas fa-underline"></i></button>
                                            </div>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-outline-secondary" data-command="justifyLeft"><i class="fas fa-align-left"></i></button>
                                                <button type="button" class="btn btn-outline-secondary" data-command="justifyCenter"><i class="fas fa-align-center"></i></button>
                                                <button type="button" class="btn btn-outline-secondary" data-command="justifyRight"><i class="fas fa-align-right"></i></button>
                                            </div>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-outline-secondary" data-command="insertUnorderedList"><i class="fas fa-list-ul"></i></button>
                                                <button type="button" class="btn btn-outline-secondary" data-command="insertOrderedList"><i class="fas fa-list-ol"></i></button>
                                            </div>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-command="createLink"><i class="fas fa-link"></i></button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-command="insertImage"><i class="fas fa-image"></i></button>
                                            <button type="button" class="btn ai-assistant btn-sm" id="aiAssistantBtn">
                                                <i class="fas fa-robot me-1"></i> AI Assistant
                                            </button>
                                        </div>
                                        <div class="editor-content" id="emailContent" contenteditable="true">
                                            <p>Hello {first_name},</p>
                                            <p>We're excited to have you on board! Thank you for joining our community.</p>
                                            <p>If you have any questions, feel free to reach out to our support team.</p>
                                            <p>Best regards,<br>The Team</p>
                                        </div>
                                        
                                        <!-- Hidden input field for body content -->
                                        <div class="hidden-body-field">
                                            <label for="body" class="form-label">Body Content (HTML)</label>
                                            <textarea class="form-control" id="body" name="body" rows="6" readonly></textarea>
                                        </div>
                                        
                                        <div class="editor-actions">
                                            <button type="button" class="action-btn" id="insertVariableBtn">
                                                <i class="fas fa-magic"></i> Insert Variable
                                            </button>
                                            <button type="button" class="action-btn" data-command="insertImage">
                                                <i class="fas fa-image"></i> Insert Image
                                            </button>
                                            <button type="button" class="action-btn" data-command="createLink">
                                                <i class="fas fa-link"></i> Insert Link
                                            </button>
                                            <button type="button" class="action-btn" id="updateBodyBtn">
                                                <i class="fas fa-sync-alt"></i> Update Body Content
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="template-preview">
                                        <div class="preview-header">
                                            <h3 class="h5">Available Variables</h3>
                                            <p class="text-muted small">Click to insert variables into your template</p>
                                        </div>
                                        
                                        <div class="variables-container">
                                            <span class="token-badge" data-variable="{first_name}">{first_name}</span>
                                            <span class="token-badge" data-variable="{last_name}">{last_name}</span>
                                            <span class="token-badge" data-variable="{email}">{email}</span>
                                            <span class="token-badge" data-variable="{company}">{company}</span>
                                            <span class="token-badge" data-variable="{position}">{position}</span>
                                            <span class="token-badge" data-variable="{phone}">{phone}</span>
                                            <span class="token-badge" data-variable="{date}">{date}</span>
                                            <span class="token-badge" data-variable="{activation_link}">{activation_link}</span>
                                            <span class="token-badge" data-variable="{login_link}">{login_link}</span>
                                            <span class="token-badge" data-variable="{support_email}">{support_email}</span>
                                        </div>
                                        
                                        <div class="preview-header mt-4">
                                            <h3 class="h5">Template Preview</h3>
                                            <p class="text-muted small">See how your email will look</p>
                                        </div>
                                        
                                        <div class="preview-content border rounded p-3 bg-light">
                                            <p class="mb-1"><strong>Subject:</strong> <span id="preview-subject">Welcome to Our Service!</span></p>
                                            <p class="mb-1"><strong>To:</strong> john@example.com</p>
                                            <p class="mb-0"><strong>From:</strong> support@company.com</p>
                                            <hr>
                                            <div class="email-preview" id="email-preview">
                                                <p>Hello John,</p>
                                                <p>We're excited to have you on board! Thank you for joining our community.</p>
                                                <p>If you have any questions, feel free to reach out to our support team.</p>
                                                <p>Best regards,<br>The Team</p>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <button type="button" class="btn btn-outline-primary w-100" id="previewBtn">
                                                <i class="fas fa-eye me-2"></i> Preview Full Email
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                <div>
                                    <button type="button" class="btn btn-outline-secondary" id="saveDraftBtn">
                                        <i class="fas fa-save me-2"></i> Save Draft
                                    </button>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-outline-secondary me-2" id="cancelBtn">
                                        <i class="fas fa-times me-2"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-paper-plane me-2"></i> Create Template
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Data Preview Section -->
                <div class="mt-4">
                    <h4>Form Data Preview</h4>
                    <div class="data-preview">
                        <div><strong>Template Name:</strong> <span id="data-template-name"></span></div>
                        <div><strong>Subject:</strong> <span id="data-subject"></span></div>
                        <div><strong>Body Content:</strong> <span id="data-body"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Assistant Modal -->
    <div class="ai-modal" id="aiModal">
        <div class="ai-modal-content">
            <div class="ai-modal-header">
                <h3 class="mb-0"><i class="fas fa-robot me-2"></i> AI Assistant</h3>
                <button type="button" class="btn-close btn-close-white" id="closeAiModal"></button>
            </div>
            <div class="ai-modal-body" id="aiModalBody">
                <h4 class="mb-4">What would you like to generate?</h4>
                
                <div class="ai-option" data-type="welcome">
                    <h5><i class="fas fa-hand-wave me-2"></i> Welcome Email</h5>
                    <p>Generate a friendly welcome email for new users</p>
                </div>
                
                <div class="ai-option" data-type="promotional">
                    <h5><i class="fas fa-bullhorn me-2"></i> Promotional Email</h5>
                    <p>Create an engaging promotional email for your product</p>
                </div>
                
                <div class="ai-option" data-type="newsletter">
                    <h5><i class="fas fa-newspaper me-2"></i> Newsletter</h5>
                    <p>Generate a professional newsletter template</p>
                </div>
                
                <div class="ai-option" data-type="followup">
                    <h5><i class="fas fa-history me-2"></i> Follow-up Email</h5>
                    <p>Create a follow-up email for after a meeting or purchase</p>
                </div>
            </div>
            
            <div class="ai-generating" id="aiGenerating">
                <div class="spinner"></div>
                <h4>AI is generating content...</h4>
                <p>This may take a few seconds</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const emailContent = document.getElementById('emailContent');
            const bodyInput = document.getElementById('body');
            const aiAssistantBtn = document.getElementById('aiAssistantBtn');
            const aiModal = document.getElementById('aiModal');
            const closeAiModal = document.getElementById('closeAiModal');
            const aiModalBody = document.getElementById('aiModalBody');
            const aiGenerating = document.getElementById('aiGenerating');
            const aiOptions = document.querySelectorAll('.ai-option');
            const tokenBadges = document.querySelectorAll('.token-badge');
            const toolbarButtons = document.querySelectorAll('.editor-toolbar button');
            const emailSubject = document.getElementById('subject');
            const previewSubject = document.getElementById('preview-subject');
            const previewBtn = document.getElementById('previewBtn');
            const emailTemplateForm = document.getElementById('emailTemplateForm');
            const messageAlert = document.getElementById('messageAlert');
            const messageText = document.getElementById('messageText');
            const saveDraftBtn = document.getElementById('saveDraftBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const updateBodyBtn = document.getElementById('updateBodyBtn');
            const templateNameInput = document.getElementById('template_name');
            
            // Data preview elements
            const dataTemplateName = document.getElementById('data-template-name');
            const dataSubject = document.getElementById('data-subject');
            const dataBody = document.getElementById('data-body');
            
            // Function to update the body input field
            function updateBodyInput() {
                bodyInput.value = emailContent.innerHTML;
                updateDataPreview();
                showMessage('Body content updated successfully!', 'success');
            }
            
            // Function to update data preview
            function updateDataPreview() {
                dataTemplateName.textContent = templateNameInput.value || 'Not set';
                dataSubject.textContent = emailSubject.value || 'Not set';
                dataBody.textContent = bodyInput.value ? 'Content available (' + bodyInput.value.length + ' characters)' : 'No content';
            }
            
            // Update subject preview
            emailSubject.addEventListener('input', function() {
                previewSubject.textContent = this.value || 'Welcome to Our Service!';
                updateDataPreview();
            });
            
            // Update template name preview
            templateNameInput.addEventListener('input', updateDataPreview);
            
            // Token badges functionality
            tokenBadges.forEach(badge => {
                badge.addEventListener('click', function() {
                    const variable = this.getAttribute('data-variable');
                    insertTextAtCursor(variable);
                    updatePreview();
                });
            });
            
            // Toolbar functionality
            toolbarButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const command = this.getAttribute('data-command');
                    
                    if (command === 'insertImage') {
                        const url = prompt('Enter image URL:', 'https://');
                        if (url) {
                            document.execCommand('insertImage', false, url);
                        }
                    } else if (command === 'createLink') {
                        const url = prompt('Enter URL:', 'https://');
                        if (url) {
                            document.execCommand('createLink', false, url);
                        }
                    } else {
                        document.execCommand(command, false, null);
                    }
                    
                    updatePreview();
                    updateBodyInput();
                });
            });
            
            // Update body button
            updateBodyBtn.addEventListener('click', updateBodyInput);
            
            // Auto-update body when content changes (with debounce)
            let updateTimeout;
            emailContent.addEventListener('input', function() {
                clearTimeout(updateTimeout);
                updateTimeout = setTimeout(function() {
                    updateBodyInput();
                    updatePreview();
                }, 500);
            });
            
            // AI Assistant functionality
            aiAssistantBtn.addEventListener('click', function() {
                aiModal.style.display = 'flex';
            });
            
            closeAiModal.addEventListener('click', function() {
                aiModal.style.display = 'none';
            });
            
            aiOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const type = this.getAttribute('data-type');
                    aiModalBody.style.display = 'none';
                    aiGenerating.style.display = 'block';
                    
                    // Simulate AI generation with a timeout
                    setTimeout(() => {
                        generateAIContent(type);
                        aiModal.style.display = 'none';
                        aiModalBody.style.display = 'block';
                        aiGenerating.style.display = 'none';
                        updateBodyInput();
                    }, 2000);
                });
            });
            
            // Close modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target === aiModal) {
                    aiModal.style.display = 'none';
                }
            });
            
            // Preview button
            previewBtn.addEventListener('click', function() {
                updateBodyInput();
                alert('Full preview would show here. Body content has been updated in the form field.');
            });
            
           // In your form submission handler
 emailTemplateForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Update body content
        updateBodyInput();

        // Show loading state
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Saving...';
        submitBtn.disabled = true;

        // Submit the form via AJAX
        fetch(emailTemplateForm.action, {
            method: 'POST',
            body: new FormData(emailTemplateForm),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('Template created successfully!', 'success');
                setTimeout(() => {
                    window.location.href = "{{ route('admin.email-templates.index') }}";
                }, 1500);
            } else if (data.errors) {
                // Show Laravel validation errors
                const messages = Object.values(data.errors).flat().join('<br>');
                showMessage(messages, 'danger');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            } else {
                throw new Error(data.message || 'An unexpected error occurred.');
            }
        })
        .catch(error => {
            showMessage(error.message, 'danger');
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });

            
            // Save draft functionality
            saveDraftBtn.addEventListener('click', function() {
                updateBodyInput();
                
                // Show loading state
                const originalText = saveDraftBtn.innerHTML;
                saveDraftBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Saving...';
                saveDraftBtn.disabled = true;
                
                // Simulate saving draft
                setTimeout(() => {
                    showMessage('Draft saved successfully!', 'success');
                    
                    // Reset button state
                    saveDraftBtn.innerHTML = originalText;
                    saveDraftBtn.disabled = false;
                }, 1000);
            });
            
            // Cancel button
            cancelBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
                    window.location.href = "#";
                }
            });
            
            // Function to insert text at cursor
            function insertTextAtCursor(text) {
                const sel = window.getSelection();
                if (sel.rangeCount) {
                    const range = sel.getRangeAt(0);
                    range.deleteContents();
                    const textNode = document.createTextNode(text);
                    range.insertNode(textNode);
                    range.setStartAfter(textNode);
                    range.setEndAfter(textNode);
                    sel.removeAllRanges();
                    sel.addRange(range);
                }
            }
            
            // Function to update preview
            function updatePreview() {
                document.getElementById('email-preview').innerHTML = emailContent.innerHTML;
            }
            
            // Function to generate AI content based on type
            function generateAIContent(type) {
                let content = '';
                
                switch(type) {
                    case 'welcome':
                        content = `<p>Hello {first_name},</p>
                                <p>Welcome to {company}! We're thrilled to have you as part of our community.</p>
                                <p>Your account has been successfully created, and you can now access all our features.</p>
                                <p>If you have any questions or need assistance, please don't hesitate to contact our support team at {support_email}.</p>
                                <p>Best regards,<br>The {company} Team</p>`;
                        break;
                    case 'promotional':
                        content = `<p>Hello {first_name},</p>
                                <p>We have exciting news for you! For a limited time, we're offering special discounts on our premium products.</p>
                                <p>Don't miss this opportunity to enhance your experience with our exclusive offers.</p>
                                <p>Click here to explore the deals: {promo_link}</p>
                                <p>Offer valid until {expiration_date}.</p>
                                <p>Best regards,<br>The {company} Team</p>`;
                        break;
                    case 'newsletter':
                        content = `<h2>Monthly Newsletter</h2>
                                <p>Hello {first_name},</p>
                                <p>Here's what's new this month at {company}:</p>
                                <ul>
                                    <li>Feature updates and improvements</li>
                                    <li>Upcoming events and webinars</li>
                                    <li>Tips and tricks to get the most out of our services</li>
                                </ul>
                                <p>Thank you for being a valued member of our community!</p>
                                <p>The {company} Team</p>`;
                        break;
                    case 'followup':
                        content = `<p>Hello {first_name},</p>
                                <p>Thank you for your recent interaction with us. We hope you're satisfied with our service.</p>
                                <p>If you have any feedback or questions, we'd love to hear from you. Your satisfaction is our top priority.</p>
                                <p>Please don't hesitate to reach out to us at {support_email} or reply directly to this email.</p>
                                <p>Best regards,<br>{agent_name}<br>The {company} Team</p>`;
                        break;
                }
                
                emailContent.innerHTML = content;
                updatePreview();
            }
            
            // Function to show messages
            function showMessage(text, type) {
                messageText.textContent = text;
                messageAlert.className = `alert alert-${type}`;
                messageAlert.style.display = 'block';
                
                // Hide message after 5 seconds
                setTimeout(() => {
                    messageAlert.style.display = 'none';
                }, 5000);
            }
            
            // Initialize preview and body input
            updatePreview();
            updateBodyInput();
        });
    </script>
</body>
</html>