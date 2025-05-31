/**
 * Term Drawer Component
 * 
 * Handles the creation of new terms (categories/tags) via a drawer component
 * and updates the post form without page reload.
 */
window.termDrawer = function(taxonomyName) {
    return {
        isOpen: false,
        isSubmitting: false,
        formData: {
            name: '',
            slug: '',
            description: '',
            parent_id: '',
            taxonomy: taxonomyName
        },
        errors: {},
        
        /**
         * Open the drawer
         */
        openDrawer() {
            this.resetForm();
            this.isOpen = true;
            
            // Add body class to prevent scrolling when drawer is open
            document.body.classList.add('overflow-hidden');
        },
        
        /**
         * Reset the form data and errors
         */
        resetForm() {
            this.formData = {
                name: '',
                slug: '',
                description: '',
                parent_id: '',
                taxonomy: taxonomyName
            };
            this.errors = {};
        },
        
        /**
         * Close the drawer
         */
        closeDrawer() {
            this.isOpen = false;
            
            // Remove body class to allow scrolling again
            document.body.classList.remove('overflow-hidden');
        },
        
        /**
         * Save the term via AJAX
         */
        async saveTerm() {
            if (this.isSubmitting) return;
            
            // Validate required fields
            if (!this.formData.name || this.formData.name.trim() === '') {
                this.errors.name = 'Name is required';
                return;
            }
            
            this.isSubmitting = true;
            this.errors = {};
            
            try {
                // Get CSRF token - safely with fallback
                let token = '';
                const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                if (tokenMeta) {
                    token = tokenMeta.getAttribute('content');
                } else {
                    // Try to get from a form if meta tag is not available
                    const tokenInput = document.querySelector('input[name="_token"]');
                    if (tokenInput) {
                        token = tokenInput.value;
                    } else {
                        throw new Error('CSRF token not found. Please refresh the page and try again.');
                    }
                }
                
                // Make the API request
                const response = await fetch(`/api/admin/terms/${taxonomyName}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(this.formData)
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    // Handle validation errors
                    if (response.status === 422 && data.errors) {
                        this.errors = data.errors;
                        this.isSubmitting = false;
                        return;
                    }
                    
                    // Handle other errors
                    throw new Error(data.message || 'An error occurred while saving the term');
                }
                
                // Success - add the new term to the form
                if (data.term) {
                    this.addTermToForm(data.term);
                    
                    // Show success toast notification
                    if (typeof window.showToast === 'function') {
                        window.showToast('success', 'Success!', data.message || `${this.formData.name} created successfully`);
                    }
                    
                    // Close the drawer
                    this.closeDrawer();
                } else {
                    throw new Error('Invalid response from server: Term data missing');
                }
                
            } catch (error) {
                console.error('Error saving term:', error);
                
                // Show error toast notification
                if (typeof window.showToast === 'function') {
                    window.showToast('error', 'Error', error.message || 'An error occurred while saving the term');
                }
            } finally {
                this.isSubmitting = false;
            }
        },
        
        /**
         * Add the newly created term to the form
         */
        addTermToForm(term) {
            // Validate term data
            if (!term || !term.id) {
                console.error('Invalid term data:', term);
                return;
            }
            
            // Find the taxonomy checkbox container
            const taxonomyContainer = document.querySelector(`[data-taxonomy="${taxonomyName}"]`);
            if (!taxonomyContainer) {
                console.error(`Taxonomy container for ${taxonomyName} not found`);
                return;
            }
            
            // Create the new checkbox element
            const termItem = document.createElement('div');
            termItem.className = 'flex items-start mb-2';
            
            // Determine if this is a hierarchical term and add appropriate indentation
            if (term.parent_id) {
                const parentLevel = this.getTermLevel(term.parent_id);
                const indentClass = `ml-${(parentLevel + 1) * 4}`;
                
                // Only add the class if it's not empty
                if (indentClass && indentClass !== 'ml-0') {
                    termItem.classList.add(indentClass);
                }
                
                // If this is a child term, we might need to add it to a specific parent container
                const parentContainer = document.querySelector(`[data-term-children="${term.parent_id}"]`);
                if (parentContainer) {
                    parentContainer.appendChild(termItem);
                    return;
                }
            }
            
            // Create the checkbox HTML
            termItem.innerHTML = `
                <input type="checkbox" name="taxonomy_${taxonomyName}[]" id="term_${term.id}" value="${term.id}"
                    class="mt-1 h-4 w-4 text-brand-500 border-gray-300 rounded focus:ring-brand-400 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-brand-500"
                    checked>
                <label for="term_${term.id}" class="ml-2 block text-sm text-gray-700 dark:text-gray-400">
                    ${term.name}
                </label>
            `;
            
            // Add the new term to the container
            const termsListContainer = taxonomyContainer.querySelector('.terms-list') || taxonomyContainer;
            termsListContainer.appendChild(termItem);
            
            // If this is the first term, remove the "No terms found" message
            const noTermsMessage = taxonomyContainer.querySelector('.no-terms-message');
            if (noTermsMessage) {
                noTermsMessage.remove();
            }
        },
        
        /**
         * Get the nesting level of a term
         */
        getTermLevel(termId) {
            if (!termId) return 0;
            
            // This is a simplified version - in a real app you might need to traverse the DOM
            // to determine the actual level of a parent term
            try {
                const parentElement = document.querySelector(`#term_${termId}`);
                if (!parentElement) return 0;
                
                const parentContainer = parentElement.closest('[data-term-children]');
                if (!parentContainer) return 0;
                
                // Count parent containers to determine level
                let level = 1;
                let currentContainer = parentContainer;
                
                while (currentContainer) {
                    const parentId = currentContainer.getAttribute('data-term-children');
                    if (!parentId) break;
                    
                    currentContainer = document.querySelector(`[data-term-children="${parentId}"]`);
                    if (currentContainer) level++;
                }
                
                return level;
            } catch (error) {
                console.error('Error determining term level:', error);
                return 0;
            }
        }
    };
}
