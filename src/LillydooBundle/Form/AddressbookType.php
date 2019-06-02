<?php

namespace LillydooBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use  Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints as Assert;

class AddressbookType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', TextType::class,
                                array(
                                        'data' => $options['data']->getFirstname(),
                                        'label' => "First name",
                                        'constraints'=>array( 
                                                              new Assert\NotBlank(
                                                                      array(
                                                                            'message' => 'This value should not be blank!',
                                                                            )        
                                                                    )
                                                            ),
                                        'attr' => array(
                                                        //'style' => 'width:250px', 
                                                        )                                   
                                    ))
                ->add('lastname', TextType::class,
                                array(
                                        'data' => $options['data']->getLastname(),
                                        'label' => "Last name",
                                        'constraints'=>array( 
                                                              new Assert\NotBlank(
                                                                      array(
                                                                            'message' => 'This value should not be blank!',
                                                                            )        
                                                                    )
                                                            ),
                                        'attr' => array(
                                                        //'style' => 'width:250px', 
                                                        )                                   
                                    ))
                ->add('street', TextType::class,
                                array(
                                        'data' => $options['data']->getStreet(),
                                        'label' => "Street",
                                        'constraints'=>array( 
                                                              new Assert\NotBlank(
                                                                      array(
                                                                            'message' => 'This value should not be blank!',
                                                                            )        
                                                                    )
                                                            ),
                                        'attr' => array(
                                                        //'style' => 'width:250px', 
                                                        )                                   
                                    ))
                ->add('number', NumberType::class,
                                array(
                                        'data' => $options['data']->getNumber(),
                                        'label' => "Street number",
                                        'constraints'=>array( 
                                                              new Assert\NotBlank(
                                                                      array(
                                                                            'message' => 'This value should not be blank!',
                                                                            )        
                                                                    )
                                                                    ,new Assert\Type([
                                                                               'type' => 'numeric',
                                                                               'message' => 'The value should be a number!.',
                                                                           ])                                           
                                                            ),
                                        'attr' => array(
                                                        //'style' => 'width:250px', 
                                                        )                                   
                                    ))
                ->add('country', ChoiceType::class, 
                                        array(
                                                'data' => $options['data']->getCountry(),
                                                'choices'  => array(
                                                            'Germany' => 'Germany',
                                                            'Romania' => 'Romania',
                                                            'Belgium' => 'Belgium',
                                                            'Japan' => 'Japan',
                                                            'France' => 'France',
                                                            'Bulgaria' => 'Bulgaria',                                                   
                                                ),
                                                'placeholder' => '-- Choose an option --', 
                                                'label'=>"Country",
                                                // *this line is important*
                                               // 'choices_as_values' => false,
                                                'constraints'=>array(
                                                                    new Assert\NotNull(
                                                                              array(
                                                                                    'message' => 'Choose a valid option!',
                                                                                    ) 
                                                                    ),
                                                    )
                                            )
                )   
                ->add('phonenumber', TextType::class,
                                array(
                                        'data' => $options['data']->getPhonenumber(),
                                        'label' => "Phone number",
                                        'constraints'=>array( 
                                                              new Assert\NotBlank(
                                                                      array(
                                                                            'message' => 'This value should not be blank!',
                                                                            )        
                                                                    )
                                                            ),
                                        'attr' => array(
                                                        //'style' => 'width:250px', 
                                                        )                                   
                                    ))
                ->add('birthday',DateType::class, array(
                                        'data' => $options['data']->getBirthday(),
                                        // renders it as a single text box
                                        //'format' => 'dd-mm-yy',
                                         'widget' => 'single_text',
                                         'attr' =>array('class'=>'js-datepicker'),
                                         'html5' =>false,
                                        'constraints'=>array( 
                                                              new Assert\NotBlank(
                                                                      array(
                                                                            'message' => 'This value should not be blank!',
                                                                            )        
                                                                    )
                                                            )
                    ))
                ->add('email', TextType::class,
                                array(
                                        'data' => $options['data']->getEmail(),
                                        'label' => "Email",
                                        'constraints'=>array( 
                                                            new Assert\NotBlank(
                                                                    array(
                                                                            'message' => 'This value should not be blank!',
                                                                        )        
                                                                    )
                                                            ,new Assert\Email(
                                                                    array(
                                                                             'message' => 'Not a valid email address!',
                                                                          ) 
                                                                    ) 
                                                            ),
                                        'attr' => array(
                                                        //'style' => 'width:250px', 
                                                        )                                   
                                    ))
                ->add('zipcode', TextType::class,
                                array(
                                        'data' => $options['data']->getZipcode(),
                                        'label' => "Zip Code",
                                        'constraints'=>array( 
                                                              new Assert\NotBlank(
                                                                      array(
                                                                            'message' => 'This value should not be blank!',
                                                                            )        
                                                                    )
                                                            ),
                                        'attr' => array(
                                                        //'style' => 'width:250px', 
                                                        )                                   
                    ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LillydooBundle\Entity\Addressbook'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lillydoobundle_addressbook';
    }


}
