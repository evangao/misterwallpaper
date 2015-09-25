<?xml version="1.0" encoding="utf-8" ?>
<definitions name="QAS"
             targetNamespace="http://www.qas.com/OnDemand-2011-03"
             xmlns="http://schemas.xmlsoap.org/wsdl/"
             xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
             xmlns:xs="http://www.w3.org/2001/XMLSchema"
             xmlns:qas="http://www.qas.com/OnDemand-2011-03" >
      <types>
        <xs:schema elementFormDefault="qualified"
                   targetNamespace="http://www.qas.com/OnDemand-2011-03"
                   xmlns="http://www.w3.org/2001/XMLSchema"
                   xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" >

          <xs:import namespace="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" schemaLocation="oasis-200401-wss-wssecurity-secext-1.0.xsd"/>

          <xs:complexType name ="QAAuthentication">
            <xs:sequence>
              <xs:element minOccurs="1" maxOccurs="1" name="Username" type="xs:string"/>
              <xs:element minOccurs="1" maxOccurs="1" name="Password" type="xs:string"/>
            </xs:sequence>
          </xs:complexType>
          <xs:element name="QAAuthentication" type="qas:QAAuthentication"/>

          <xs:complexType name="QAQueryHeader">
            <xs:sequence minOccurs = "1" maxOccurs="1">
              <xs:element name="QAAuthentication" type="qas:QAAuthentication"/>
              <xs:element name="Security" type="wsse:SecurityHeaderType" />
            </xs:sequence>
          </xs:complexType>
          <xs:element name="QAQueryHeader" type="qas:QAQueryHeader"/>

          <xs:complexType name ="QAInformation">
            <xs:sequence>
              <xs:element minOccurs="1" maxOccurs="1" name="StateTransition" type="xs:string" />
              <xs:element minOccurs="1" maxOccurs="1" name="CreditsUsed" type="xs:long" />
            </xs:sequence>
          </xs:complexType>
          <xs:element name="QAInformation" type="qas:QAInformation"/>

          <xs:simpleType name="RequestTagType">
            <xs:annotation>
              <xs:documentation>RequestTagType defines a transaction(s) identifier</xs:documentation>
            </xs:annotation>
            <xs:restriction base="xs:string">
              <xs:pattern value="^[A-Za-z0-9\\\ /._:-]{0,256}$" />
            </xs:restriction>
          </xs:simpleType>

          <xs:element name="QASearch">
            <xs:annotation>
              <xs:documentation>QASearch defines a search request</xs:documentation>
              <xs:documentation>The child elements are as follows:</xs:documentation>
              <xs:documentation>Country : The country dataset to use</xs:documentation>
              <xs:documentation>Engine : The search engine to use, and any engine specific configuration settings</xs:documentation>
              <xs:documentation>Layout : The layout to use when creating a formatted address (required by verification engine only)</xs:documentation>
              <xs:documentation>Search : The actual search string</xs:documentation>
              <xs:documentation>FormattedAddressInPicklist: Please refer to the associated Pro On Demand web service documentation for information about this feature.</xs:documentation>
              <xs:documentation>RequestTag : String for marking request</xs:documentation>
              <xs:documentation>Localisation : Please refer to the associated Pro On Demand web service documentation for information about this feature.</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
                <xs:element name="Country" type="qas:DataIDType" />
                <xs:element name="Engine" type="qas:EngineType"/>
                <xs:element name="Layout" type="xs:string" minOccurs="0"/>
                <xs:element name="Search" type="xs:string" />
                <xs:element name="FormattedAddressInPicklist" type="xs:boolean" default="false" minOccurs="0"/>
              </xs:sequence>
              <xs:attribute name="Localisation" type="xs:string"/>
              <xs:attribute name="RequestTag" type="qas:RequestTagType"/>
            </xs:complexType>
          </xs:element>


          <xs:simpleType name="DataIDType">
            <xs:annotation>
              <xs:documentation>DataIDType defines a data identifier, a 3 charater code</xs:documentation>
            </xs:annotation>
            <xs:restriction base="xs:string">
              <xs:pattern value="[A-Za-z0-9][A-Za-z0-9][A-Za-z0-9]" />
            </xs:restriction>
          </xs:simpleType>

          <xs:complexType name="EngineType">
            <xs:annotation>
              <xs:documentation>EngineType specifies the engine to use for a search, and any engine options</xs:documentation>
              <xs:documentation>The various attributes are as follows:</xs:documentation>
              <xs:documentation>Flatten       : Whether or not to flatten the picklist returned by the search</xs:documentation>
              <xs:documentation>Intensity     : How hard the search engine will search to get a match</xs:documentation>
              <xs:documentation>PromptSet     : The prompt set to apply to the search string</xs:documentation>
              <xs:documentation>Threshold     : The typedown threshold (typedown engine only)</xs:documentation>
              <xs:documentation>Timeout       : The time out period in milliseconds</xs:documentation>
            </xs:annotation>
            <xs:simpleContent>
              <xs:extension base="qas:EngineEnumType">
                <xs:attribute name="Flatten" type="xs:boolean" />
                <xs:attribute name="Intensity" type="qas:EngineIntensityType" />
                <xs:attribute name="PromptSet" type="qas:PromptSetType" />
                <xs:attribute name="Threshold" type="qas:ThresholdType" />
                <xs:attribute name="Timeout" type="qas:TimeoutType" />
              </xs:extension>
            </xs:simpleContent>
          </xs:complexType>

          <xs:simpleType name="EngineEnumType">
            <xs:annotation>
              <xs:documentation>The available engines</xs:documentation>
            </xs:annotation>
            <xs:restriction base="xs:string">
              <xs:enumeration value="Singleline" />
              <xs:enumeration value="Typedown" />
              <xs:enumeration value="Verification" />
              <xs:enumeration value="Keyfinder" />
              <xs:enumeration value="Intuitive" />
            </xs:restriction>
          </xs:simpleType>

          <xs:simpleType name="ThresholdType">
            <xs:annotation>
              <xs:documentation>The picklist threshold - the maximum size of the picklist</xs:documentation>
            </xs:annotation>
            <xs:restriction base="xs:positiveInteger">
              <xs:minInclusive value="5" />
              <xs:maxInclusive value="750" />
            </xs:restriction>
          </xs:simpleType>

          <xs:simpleType name="EngineIntensityType">
            <xs:annotation>
              <xs:documentation>The available searching intensity levels</xs:documentation>
            </xs:annotation>
            <xs:restriction base="xs:string">
              <xs:enumeration value="Exact" />
              <xs:enumeration value="Close" />
              <xs:enumeration value="Extensive" />
            </xs:restriction>
          </xs:simpleType>

          <xs:simpleType name="TimeoutType">
            <xs:annotation>
              <xs:documentation>The server searching timeout - how long before a search is aborted (milliseconds)</xs:documentation>
            </xs:annotation>
            <xs:restriction base="xs:nonNegativeInteger">
              <xs:minInclusive value="0" />
              <xs:maxInclusive value="600000" />
            </xs:restriction>
          </xs:simpleType>

          <xs:simpleType name="PromptSetType">
            <xs:annotation>
              <xs:documentation>The available prompt sets</xs:documentation>
            </xs:annotation>
            <xs:restriction base="xs:string">
              <xs:enumeration value="OneLine" />
              <xs:enumeration value="Default" />
              <xs:enumeration value="Generic" />
              <xs:enumeration value="Optimal" />
              <xs:enumeration value="Alternate" />
              <xs:enumeration value="Alternate2" />
              <xs:enumeration value="Alternate3" />
            </xs:restriction>
          </xs:simpleType>

          <xs:element name="QASearchResult">
            <xs:annotation>
              <xs:documentation>QASearchResult describes the results of a search</xs:documentation>
              <xs:documentation>The child elements are as follows:</xs:documentation>
              <xs:documentation>QAPicklist  : The picklist produced by the search</xs:documentation>
              <xs:documentation>
                QAAddress   : A formatted address produced by the search.
                Note that only the verification engine will ever produce a formatted address.
                Other engines will only ever produce a picklist.
              </xs:documentation>
              <xs:documentation>VerificationFlags   : Please refer to the associated Pro On Demand web service documentation for information about this feature.</xs:documentation>
              <xs:documentation>
                The VerifyLevel attribute specifies the level to which the verification engine has
                verified the input address. It can be ignored when using all other engines.
              </xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
                <xs:element name="QAPicklist" type="qas:QAPicklistType" minOccurs="0"/>
                <xs:element name="QAAddress" type="qas:QAAddressType" minOccurs="0"/>
                <xs:element name="VerificationFlags" type="qas:VerificationFlagsType" minOccurs="0"/>
              </xs:sequence>
              <xs:attribute name="VerifyLevel" type="qas:VerifyLevelType" default="None"/>
            </xs:complexType>
          </xs:element>

          <xs:simpleType name="VerifyLevelType">
            <xs:annotation>
              <xs:documentation>The possible verification levels</xs:documentation>
            </xs:annotation>
            <xs:restriction base="xs:string">
              <xs:enumeration value="None"/>
              <xs:enumeration value="Verified"/>
              <xs:enumeration value="InteractionRequired"/>
              <xs:enumeration value="PremisesPartial"/>
              <xs:enumeration value="StreetPartial"/>
              <xs:enumeration value="Multiple"/>
              <xs:enumeration value="VerifiedPlace"/>
              <xs:enumeration value="VerifiedStreet"/>
            </xs:restriction>
          </xs:simpleType>

          <xs:element name="QARefine">
            <xs:annotation>
              <xs:documentation>QARefine defines a refinement request</xs:documentation>
              <xs:documentation>The child elements are as follows:</xs:documentation>
              <xs:documentation>Moniker    : The Search Point Moniker to refine</xs:documentation>
              <xs:documentation>Refinement : The refinement text</xs:documentation>
              <xs:documentation>Layout     : The layout to use when creating a formatted address (used in certain scenarios for formatting picklist text)</xs:documentation>
              <xs:documentation>FormattedAddressInPicklist: Please refer to the associated Pro On Demand web service documentation for information about this feature.</xs:documentation>
              <xs:documentation>The attributes are as follows:</xs:documentation>
              <xs:documentation>Threshold  : The picklist threshold (i.e. the maximum size of the picklist)</xs:documentation>
              <xs:documentation>Timeout    : The timeout period in milliseconds</xs:documentation>
              <xs:documentation>Localisation : Please refer to the associated Pro On Demand web service documentation for information about this feature.</xs:documentation>
              <xs:documentation>RequestTag : String for marking request</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
                <xs:element name="Moniker" type="xs:string"/>
                <xs:element name="Refinement" type="xs:string"/>
                <xs:element name="Layout" type="xs:string" minOccurs="0"/>
                <xs:element name="FormattedAddressInPicklist" type="xs:boolean" default="false" minOccurs="0"/>
              </xs:sequence>
              <xs:attribute name="Threshold" type="qas:ThresholdType" />
              <xs:attribute name="Timeout" type="qas:TimeoutType" />
              <xs:attribute name="Localisation" type="xs:string"/>
              <xs:attribute name="RequestTag" type="qas:RequestTagType"/>
            </xs:complexType>
          </xs:element>

          <xs:element name="Picklist">
            <xs:annotation>
              <xs:documentation>Picklist describes a returned picklist</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
                <xs:element name="QAPicklist" type="qas:QAPicklistType"/>
              </xs:sequence>
            </xs:complexType>
          </xs:element>

          <xs:complexType name="QAPicklistType">
            <xs:annotation>
              <xs:documentation>QAPicklistType describes a picklist</xs:documentation>
              <xs:documentation>The child elements are as follows:</xs:documentation>
              <xs:documentation>FullPicklistMoniker : The Search Point Moniker that describes the entire picklist</xs:documentation>
              <xs:documentation>PicklistEntry       : The actual picklist entries</xs:documentation>
              <xs:documentation>Prompt              : The prompt to display to the user, indicating what information they should enter next</xs:documentation>
              <xs:documentation>Total               : The total number of available results</xs:documentation>
              <xs:documentation>The attributes are as follows:</xs:documentation>
              <xs:documentation>AutoFormatSafe      : It is suggested that you immediately format the first picklist item</xs:documentation>
              <xs:documentation>AutoFormatPastClose : There is only one exact match, so you may want immediately to format the first picklist item</xs:documentation>
              <xs:documentation>AutoStepInSafe      : It is suggested that you immediately step-in to the first picklist item</xs:documentation>
              <xs:documentation>AutoStepInPastClose : There is only one exact match, so you may want immediately to step-in to the first picklist item</xs:documentation>
              <xs:documentation>LargePotential      : Potentially, there are too many results to display</xs:documentation>
              <xs:documentation>MaxMatches          : The number of results exceeded the maximum allowed</xs:documentation>
              <xs:documentation>MoreOtherMatches    : There are additional matches that can be displayed</xs:documentation>
              <xs:documentation>OverThreshold       : There are more picklist items than the threshold value</xs:documentation>
              <xs:documentation>Timeout             : The search/refinement timed out</xs:documentation>
            </xs:annotation>
            <xs:sequence>
              <xs:element name="FullPicklistMoniker" type="xs:string" />
              <xs:element name="PicklistEntry" type="qas:PicklistEntryType" minOccurs="0" maxOccurs="unbounded" />
              <xs:element name="Prompt" type="xs:string" />
              <xs:element name="Total" type="xs:nonNegativeInteger" />
            </xs:sequence>
            <xs:attribute name="AutoFormatSafe" type="xs:boolean" default="false" />
            <xs:attribute name="AutoFormatPastClose" type="xs:boolean" default="false" />
            <xs:attribute name="AutoStepinSafe" type="xs:boolean" default="false" />
            <xs:attribute name="AutoStepinPastClose" type="xs:boolean" default="false" />
            <xs:attribute name="LargePotential" type="xs:boolean" default="false" />
            <xs:attribute name="MaxMatches" type="xs:boolean" default="false" />
            <xs:attribute name="MoreOtherMatches" type="xs:boolean" default="false" />
            <xs:attribute name="OverThreshold" type="xs:boolean" default="false" />
            <xs:attribute name="Timeout" type="xs:boolean" default="false" />
          </xs:complexType>

          <xs:complexType name="PicklistEntryType">
            <xs:annotation>
              <xs:documentation>PicklistEntryType describes an entry in a picklist</xs:documentation>
              <xs:documentation>The child elements are as follows:</xs:documentation>
              <xs:documentation>Moniker        : The Search Point Moniker that represents this picklist entry</xs:documentation>
              <xs:documentation>PartialAddress : The full details of the address captured so far</xs:documentation>
              <xs:documentation>Picklist       : The picklist text to display</xs:documentation>
              <xs:documentation>Postcode       : The postcode to display</xs:documentation>
              <xs:documentation>Score          : The percentage score assigned to the match</xs:documentation>
              <xs:documentation>QAAddress      : The Full Address for the moniker</xs:documentation>
              <xs:documentation>The attributes are as follows:</xs:documentation>
              <xs:documentation>FullAddress         : This picklist entry is a full deliverable address</xs:documentation>
              <xs:documentation>Multiples           : This entry represents multiple address lines</xs:documentation>
              <xs:documentation>CanStep             : This entry can be stepped into</xs:documentation>
              <xs:documentation>AliasMatch          : This match is an alias</xs:documentation>
              <xs:documentation>PostcodeRecoded     : This entry has a recoded postcode</xs:documentation>
              <xs:documentation>CrossBorderMatch    : This entry represents a nearby area, outside the strict initial boundaries of the search</xs:documentation>
              <xs:documentation>DummyPOBox          : This entry is the dummy PO Box entry</xs:documentation>
              <xs:documentation>Name                : This entry is a Names result</xs:documentation>
              <xs:documentation>Information         : This entry is an informational prompt</xs:documentation>
              <xs:documentation>WarnInformation     : This entry is a warning informational prompt</xs:documentation>
              <xs:documentation>IncompleteAddr      : This entry is the dummy item (for premise-less countries)</xs:documentation>
              <xs:documentation>UnresolvableRange   : This entry is a static range item that cannot be expanded</xs:documentation>
              <xs:documentation>PhantomPrimaryPoint : This entry is a Phantom Primary Point (AUS only)</xs:documentation>
              <xs:documentation>SubsidiaryData      : This entry is from the subsidiary rather than the base dataset</xs:documentation>
              <xs:documentation>ExtendedData        : This entry is from the base dataset but extended by the subsidiary dataset</xs:documentation>
              <xs:documentation>EnhancedData        : This entry is from the base dataset but enhanced by the subsidiary data set</xs:documentation>
            </xs:annotation>
            <xs:sequence>
              <xs:element name="Moniker" type="xs:string" />
              <xs:element name="PartialAddress" type="xs:string" />
              <xs:element name="Picklist" type="xs:string" />
              <xs:element name="Postcode" type="xs:string" />
              <xs:element name="Score" type="xs:nonNegativeInteger" />
              <xs:element name="QAAddress" type="qas:QAAddressType" minOccurs="0"/>
            </xs:sequence>
            <xs:attribute name="FullAddress" type="xs:boolean" default="false" />
            <xs:attribute name="Multiples" type="xs:boolean" default="false" />
            <xs:attribute name="CanStep" type="xs:boolean" default="false" />
            <xs:attribute name="AliasMatch" type="xs:boolean" default="false" />
            <xs:attribute name="PostcodeRecoded" type="xs:boolean" default="false" />
            <xs:attribute name="CrossBorderMatch" type="xs:boolean" default="false" />
            <xs:attribute name="DummyPOBox" type="xs:boolean" default="false" />
            <xs:attribute name="Name" type="xs:boolean" default="false" />
            <xs:attribute name="Information" type="xs:boolean" default="false" />
            <xs:attribute name="WarnInformation" type="xs:boolean" default="false" />
            <xs:attribute name="IncompleteAddr" type="xs:boolean" default="false" />
            <xs:attribute name="UnresolvableRange" type="xs:boolean" default="false" />
            <xs:attribute name="PhantomPrimaryPoint" type="xs:boolean" default="false" />
            <xs:attribute name="SubsidiaryData" type="xs:boolean" default="false" />
            <xs:attribute name="ExtendedData" type="xs:boolean" default="false" />
            <xs:attribute name="EnhancedData" type="xs:boolean" default="false" />
          </xs:complexType>

          <xs:element name="QAGetAddress">
            <xs:annotation>
              <xs:documentation>QAGetAddress defines a request for a formatted address</xs:documentation>
              <xs:documentation>The child elements are as follows:</xs:documentation>
              <xs:documentation>Layout   : The layout to use</xs:documentation>
              <xs:documentation>Moniker  : The Search Point Moniker of the picklist entry to format</xs:documentation>
              <xs:documentation>Localisation : Please refer to the associated Pro On Demand web service documentation for information about this feature.</xs:documentation>
              <xs:documentation>RequestTag : String for marking request</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
                <xs:element name="Layout" type="xs:string" minOccurs="0"/>
                <xs:element name="Moniker" type="xs:string" />
              </xs:sequence>
              <xs:attribute name="Localisation" type="xs:string"/>
              <xs:attribute name="RequestTag" type="qas:RequestTagType"/>
            </xs:complexType>
          </xs:element>

          <xs:element name="Address">
            <xs:complexType>
              <xs:sequence>
                <xs:element name="QAAddress" type="qas:QAAddressType"/>
              </xs:sequence>
            </xs:complexType>
          </xs:element>

          <xs:complexType name="QAAddressType">
            <xs:annotation>
              <xs:documentation>QAAddressType describes a formatted address</xs:documentation>
              <xs:documentation>The child elements are as follows:</xs:documentation>
              <xs:documentation>AddressLine  : The individual lines of the address</xs:documentation>
              <xs:documentation>The attributes are as follows:</xs:documentation>
              <xs:documentation>Overflow   : There are not enough address lines configured to display the whole address</xs:documentation>
              <xs:documentation>Truncated  : Truncation has occurred on one or more address lines</xs:documentation>
              <xs:documentation>DPVStatus : DPV Status for the Address</xs:documentation>
              <xs:documentation>MissingSubPremise: Please refer to the associated Pro On Demand web service documentation for information about this feature.</xs:documentation>
            </xs:annotation>
            <xs:sequence>
              <xs:element name="AddressLine" type="qas:AddressLineType" maxOccurs="unbounded" />
            </xs:sequence>
            <xs:attribute name="Overflow" type="xs:boolean" default="false"/>
            <xs:attribute name="Truncated" type="xs:boolean" default="false"/>
            <xs:attribute name="DPVStatus" type="qas:DPVStatusType" />
            <xs:attribute name="MissingSubPremise" type="xs:boolean" default="false"/>
          </xs:complexType>
          <xs:annotation>
            <xs:documentation>DPVStatusType specifies the DPVStatus for an Address</xs:documentation>
            <xs:documentation>The various attributes are as follows:</xs:documentation>
            <xs:documentation>DPVNotConfigured : DPV has not been configured in the Layout</xs:documentation>
            <xs:documentation>DPVConfigured : DPV has been configured in the Layout</xs:documentation>
            <xs:documentation>DPVConfirmed : The Address is DPV Confirmed</xs:documentation>
            <xs:documentation>DPVConfirmedMissingSec : The Address is DPV Confirmed but has Missing or Incorrect secondary information</xs:documentation>
            <xs:documentation>DPVNotConfirmed : The Address is NOT DPV Confirmed</xs:documentation>
            <xs:documentation>DPVLocked : DPV Address Detail Retrieval is Locked</xs:documentation>
            <xs:documentation>DPVSeedHit : The Address is a DPV Seed</xs:documentation>
          </xs:annotation>
          <xs:simpleType name="DPVStatusType">
            <xs:restriction base="xs:string">
              <xs:enumeration value="DPVNotConfigured" />
              <xs:enumeration value="DPVConfigured" />
              <xs:enumeration value="DPVConfirmed" />
              <xs:enumeration value="DPVConfirmedMissingSec" />
              <xs:enumeration value="DPVNotConfirmed" />
              <xs:enumeration value="DPVLocked" />
              <xs:enumeration value="DPVSeedHit" />
            </xs:restriction>
          </xs:simpleType>
          <xs:complexType name="AddressLineType">
            <xs:annotation>
              <xs:documentation>AddressLineType describes one line of a formatted address</xs:documentation>
              <xs:documentation>The child elements are as follows:</xs:documentation>
              <xs:documentation>Label  : The name of any address element fixed to this line</xs:documentation>
              <xs:documentation>Line   : The formatted address line</xs:documentation>
              <xs:documentation>DataplusGroup: DataPlus groups associated with this line</xs:documentation>
              <xs:documentation>The attributes are as follows:</xs:documentation>
              <xs:documentation>LineContent      : The type of data on this line</xs:documentation>
              <xs:documentation>Overflow         : Some address elements were lost from this line</xs:documentation>
              <xs:documentation>Truncated        : Truncation occurred on this line</xs:documentation>
            </xs:annotation>
            <xs:sequence>
              <xs:element name="Label" type="xs:string" minOccurs="0" />
              <xs:element name="Line" type="xs:string" minOccurs="0" />
              <xs:element name="DataplusGroup" type="qas:DataplusGroupType" minOccurs="0" maxOccurs="unbounded" />
            </xs:sequence>
            <xs:attribute name="LineContent" type="qas:LineContentType" default="Address" />
            <xs:attribute name="Overflow" type="xs:boolean" default="false" />
            <xs:attribute name="Truncated" type="xs:boolean" default="false" />
          </xs:complexType>

          <xs:complexType name="DataplusGroupType">
            <xs:sequence>
              <xs:element name="DataplusGroupItem" type="xs:string" minOccurs="1" maxOccurs="unbounded" />
            </xs:sequence>
            <xs:attribute name="GroupName" type="xs:string" />
          </xs:complexType>

          <xs:simpleType name="LineContentType">
            <xs:restriction base="xs:string">
              <xs:enumeration value="None" />
              <xs:enumeration value="Address" />
              <xs:enumeration value="Name" />
              <xs:enumeration value="Ancillary" />
              <xs:enumeration value="DataPlus" />
            </xs:restriction>
          </xs:simpleType>

          <xs:element name="QAData">
            <xs:annotation>
              <xs:documentation>QAData describes all of the datasets that are available</xs:documentation>
              <xs:documentation>DataSet : Details of a dataset</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
                <xs:element name="DataSet" type="qas:QADataSet" minOccurs="0" maxOccurs="unbounded" />
              </xs:sequence>
            </xs:complexType>
          </xs:element>

          <xs:complexType name="QADataSet">
            <xs:annotation>
              <xs:documentation>QADataSet describes a dataset</xs:documentation>
              <xs:documentation>Child elements are as follows:</xs:documentation>
              <xs:documentation>ID    : Three letter dataset ID</xs:documentation>
              <xs:documentation>Name  : Full name of dataset</xs:documentation>
            </xs:annotation>
            <xs:sequence>
              <xs:element name="ID" type="qas:DataIDType" />
              <xs:element name="Name" type="xs:string" />
            </xs:sequence>
          </xs:complexType>

          <xs:element name="QAGetData">
            <xs:annotation>
              <xs:documentation>QAGetData defines a data for GetData message</xs:documentation>
              <xs:documentation>Localisation : Please refer to the associated Pro On Demand web service documentation for information about this feature.</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
              </xs:sequence>
              <xs:attribute name="Localisation" type="xs:string"/>
            </xs:complexType>
          </xs:element>

          <xs:element name="QAGetLicenseInfo">
            <xs:annotation>
              <xs:documentation>QAGetLicenseInfo defines a data for the GetLicenseInfo message</xs:documentation>
              <xs:documentation>Localisation : Please refer to the associated Pro On Demand web service documentation for information about this feature.</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
              </xs:sequence>
              <xs:attribute name="Localisation" type="xs:string"/>
            </xs:complexType>
          </xs:element>

          <xs:element name="QAGetSystemInfo">
            <xs:annotation>
              <xs:documentation>QAGetSystemInfo a data for the GetSystemInfo message</xs:documentation>
              <xs:documentation>Localisation : Please refer to the associated Pro On Demand web service documentation for information about this feature.</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
              </xs:sequence>
              <xs:attribute name="Localisation" type="xs:string"/>
            </xs:complexType>
          </xs:element>

          <xs:element name="QAGetDataMapDetail">
            <xs:annotation>
              <xs:documentation>QAGetDataMapDetail describes a request for data map detail information</xs:documentation>
              <xs:documentation>Localisation : Please refer to the associated Pro On Demand web service documentation for information about this feature.</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
                <xs:element name="DataMap" type="qas:DataIDType" />
              </xs:sequence>
              <xs:attribute name="Localisation" type="xs:string"/>
            </xs:complexType>
          </xs:element>

          <xs:element name="QADataMapDetail">
            <xs:annotation>
              <xs:documentation>QADataMapDetail contains details of all datasets in a given data map</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
                <xs:element name="WarningLevel" type="qas:LicenceWarningLevel" />
                <xs:element name="LicensedSet" type="qas:QALicensedSet" minOccurs="0" maxOccurs="unbounded" />
              </xs:sequence>
            </xs:complexType>
          </xs:element>

          <xs:element name="QALicenceInfo">
            <xs:annotation>
              <xs:documentation>QALicenceInfo describes all of the licence information for each dataset</xs:documentation>
              <xs:documentation>Child elements are as follows:</xs:documentation>
              <xs:documentation>WarningLevel  : Warning level for the set of licensed data</xs:documentation>
              <xs:documentation>LicensedSet   : Details of a licensed dataset</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
                <xs:element name="WarningLevel" type="qas:LicenceWarningLevel" />
                <xs:element name="LicensedSet" type="qas:QALicensedSet" minOccurs="0" maxOccurs="unbounded" />
              </xs:sequence>
            </xs:complexType>
          </xs:element>

          <xs:simpleType name="LicenceWarningLevel">
            <xs:restriction base="xs:string">
              <xs:enumeration value="None" />
              <xs:enumeration value="DataExpiring" />
              <xs:enumeration value="LicenceExpiring" />
              <xs:enumeration value="ClicksLow" />
              <xs:enumeration value="Evaluation" />
              <xs:enumeration value="NoClicks" />
              <xs:enumeration value="DataExpired" />
              <xs:enumeration value="EvalLicenceExpired" />
              <xs:enumeration value="FullLicenceExpired" />
              <xs:enumeration value="LicenceNotFound" />
              <xs:enumeration value="DataUnreadable" />
            </xs:restriction>
          </xs:simpleType>

          <xs:complexType name="QALicensedSet">
            <xs:annotation>
              <xs:documentation>QALicensedSet describes a licensed dataset</xs:documentation>
              <xs:documentation>Child elements are as follows:</xs:documentation>
              <xs:documentation>ID              : Dataset ID</xs:documentation>
              <xs:documentation>Description     : Full description of dataset</xs:documentation>
              <xs:documentation>Copyright       : Copyright information</xs:documentation>
              <xs:documentation>Version         : Version of the data</xs:documentation>
              <xs:documentation>BaseCountry     : Data ID of the country to which this dataset is an extension</xs:documentation>
              <xs:documentation>Status          : A string describing the state of the data</xs:documentation>
              <xs:documentation>Server          : The name of the server where the dataset is being used</xs:documentation>
              <xs:documentation>WarningLevel    : The warning level for the dataset</xs:documentation>
              <xs:documentation>DaysLeft        : The number of days before the dataset is unusable</xs:documentation>
              <xs:documentation>DaysLeft        : The number of days before the dataset is unusable</xs:documentation>
              <xs:documentation>LicenceDaysLeft : The number of days before the licence expires</xs:documentation>
            </xs:annotation>
            <xs:sequence>
              <xs:element name="ID" type="xs:string" />
              <xs:element name="Description" type="xs:string" />
              <xs:element name="Copyright" type="xs:string" />
              <xs:element name="Version" type="xs:string" />
              <xs:element name="BaseCountry" type="xs:string" />
              <xs:element name="Status" type="xs:string" />
              <xs:element name="Server" type="xs:string" />
              <xs:element name="WarningLevel" type="qas:LicenceWarningLevel" />
              <xs:element name="DaysLeft" type="xs:nonNegativeInteger" />
              <xs:element name="DataDaysLeft" type="xs:nonNegativeInteger" />
              <xs:element name="LicenceDaysLeft" type="xs:nonNegativeInteger" />
            </xs:sequence>
          </xs:complexType>

          <xs:element name="QASystemInfo">
            <xs:annotation>
              <xs:documentation>QASystemInfo describes the current state of the system</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
                <xs:element name="SystemInfo" type="xs:string" minOccurs="0" maxOccurs="unbounded"/>
              </xs:sequence>
            </xs:complexType>
          </xs:element>

          <xs:element name="QAGetExampleAddresses">
            <xs:annotation>
              <xs:documentation>QAGetExampleAddresses defines a request for the example addresses for a given dataset</xs:documentation>
              <xs:documentation>Child elements are as follows:</xs:documentation>
              <xs:documentation>Country  : The country dataset to get example addresses for</xs:documentation>
              <xs:documentation>Layout   : The layout to use to format the example addresses</xs:documentation>
              <xs:documentation>Localisation : Please refer to the associated Pro On Demand web service documentation for information about this feature.</xs:documentation>
              <xs:documentation>RequestTag : String for marking request</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
                <xs:element name="Country" type="qas:DataIDType"/>
                <xs:element name="Layout" type="xs:string"/>
              </xs:sequence>
              <xs:attribute name="Localisation" type="xs:string"/>
              <xs:attribute name="RequestTag" type="qas:RequestTagType"/>
            </xs:complexType>
          </xs:element>

          <xs:element name="QAExampleAddresses">
            <xs:annotation>
              <xs:documentation>QAExampleAddresses describes all of the example addresses for a dataset</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
                <xs:element name="ExampleAddress" type="qas:QAExampleAddress" minOccurs="0" maxOccurs="unbounded"/>
              </xs:sequence>
            </xs:complexType>
          </xs:element>

          <xs:complexType name="QAExampleAddress">
            <xs:annotation>
              <xs:documentation>QAExampleAddress describes an example address</xs:documentation>
              <xs:documentation>Child elements are as follows:</xs:documentation>
              <xs:documentation>Address  : The formatted example address</xs:documentation>
              <xs:documentation>Comment  : A comment describing the address</xs:documentation>
            </xs:annotation>
            <xs:sequence>
              <xs:element name="Address" type="qas:QAAddressType"/>
              <xs:element name="Comment" type="xs:string"/>
            </xs:sequence>
          </xs:complexType>

          <xs:element name="QAGetLayouts">
            <xs:annotation>
              <xs:documentation>QAGetLayouts defines a request for a list of all the available layouts</xs:documentation>
              <xs:documentation>Child elements are as follows:</xs:documentation>
              <xs:documentation>Country   : The country dataset to get layouts for</xs:documentation>
              <xs:documentation>Localisation : Please refer to the associated Pro On Demand web service documentation for information about this feature.</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
                <xs:element name="Country" type="qas:DataIDType"/>
              </xs:sequence>
              <xs:attribute name="Localisation" type="xs:string"/>
            </xs:complexType>
          </xs:element>

          <xs:element name="QALayouts">
            <xs:annotation>
              <xs:documentation>QALayouts describes all the available layouts for a dataset</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
                <xs:element name="Layout" type="qas:QALayout" minOccurs="0" maxOccurs="unbounded"/>
              </xs:sequence>
            </xs:complexType>
          </xs:element>

          <xs:complexType name="QALayout">
            <xs:annotation>
              <xs:documentation>QALayout describes a layout</xs:documentation>
              <xs:documentation>Child elements are as follows:</xs:documentation>
              <xs:documentation>Name     : The name of the layout</xs:documentation>
              <xs:documentation>Comment  : A comment describing the layout</xs:documentation>
            </xs:annotation>
            <xs:sequence>
              <xs:element name="Name" type="xs:string"/>
              <xs:element name="Comment" type="xs:string"/>
            </xs:sequence>
          </xs:complexType>

          <xs:element name="QAGetPromptSet">
            <xs:annotation>
              <xs:documentation>QAGetPromptSet defines a request for details of a prompt set</xs:documentation>
              <xs:documentation>Child elements are as follows:</xs:documentation>
              <xs:documentation>Country   : The country dataset</xs:documentation>
              <xs:documentation>PromptSet : The prompt set to get details of</xs:documentation>
              <xs:documentation>Localisation : Please refer to the associated Pro On Demand web service documentation for information about this feature.</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
                <xs:element name="Country" type="qas:DataIDType"/>
                <xs:element name="Engine" type="qas:EngineType" minOccurs="0"/>
                <xs:element name="PromptSet" type="qas:PromptSetType" />
              </xs:sequence>
              <xs:attribute name="Localisation" type="xs:string"/>
            </xs:complexType>
          </xs:element>

          <xs:element name="QAPromptSet">
            <xs:annotation>
              <xs:documentation>QAPromptSet describes a prompt set</xs:documentation>
              <xs:documentation>Child element:</xs:documentation>
              <xs:documentation>Line : Describes one line of the prompt set</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
                <xs:element name="Line" type="qas:PromptLine" minOccurs="0" maxOccurs="unbounded"/>
              </xs:sequence>
              <xs:attribute name="Dynamic" type="xs:boolean" default="false" />
            </xs:complexType>
          </xs:element>

          <xs:complexType name="PromptLine">
            <xs:annotation>
              <xs:documentation>PromptLine describes a line of a prompt set</xs:documentation>
              <xs:documentation>Child elements are as follows:</xs:documentation>
              <xs:documentation>Prompt               : The prompt to display to the user</xs:documentation>
              <xs:documentation>SuggestedInputLength : The suggested length of the input buffer</xs:documentation>
              <xs:documentation>Example              : An example of possible input</xs:documentation>
            </xs:annotation>
            <xs:sequence>
              <xs:element name="Prompt" type="xs:string"/>
              <xs:element name="SuggestedInputLength" type="xs:nonNegativeInteger"/>
              <xs:element name="Example" type="xs:string"/>
            </xs:sequence>
          </xs:complexType>

          <xs:element name="QACanSearch">
            <xs:annotation>
              <xs:documentation>QACanSearch returns a boolean specifying whether a search is possible for a</xs:documentation>
              <xs:documentation>specific country, engine and layout</xs:documentation>
              <xs:documentation>Child elements are as follows:</xs:documentation>
              <xs:documentation>Country  : The country dataset</xs:documentation>
              <xs:documentation>Engine   : The search engine to use, and any engine specific configuration settings</xs:documentation>
              <xs:documentation>Layout   : The layout with which to format the address</xs:documentation>
              <xs:documentation>Localisation : Please refer to the associated Pro On Demand web service documentation for information about this feature.</xs:documentation>
              <xs:documentation></xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
                <xs:element name="Country" type="qas:DataIDType"/>
                <xs:element name="Engine" type="qas:EngineType"/>
                <xs:element name="Layout" type="xs:string" minOccurs="0"/>
              </xs:sequence>
              <xs:attribute name="Localisation" type="xs:string"/>
            </xs:complexType>
          </xs:element>

          <xs:element name="QASearchOk">
            <xs:annotation>
              <xs:documentation>QASearchOK is the response from a CanSearch operation.</xs:documentation>
              <xs:documentation>Child elements are as follows:</xs:documentation>
              <xs:documentation>IsOk        : Boolean stating whether searching is available</xs:documentation>
              <xs:documentation>ErrorCode   : The QAS error code returned</xs:documentation>
              <xs:documentation>ErrorMesage : A textual description of the error</xs:documentation>
              <xs:documentation>ErrorDetail : Detailed error history</xs:documentation>
            </xs:annotation>
            <xs:complexType>
              <xs:sequence>
                <xs:element name="IsOk" type="xs:boolean"/>
                <xs:element name="ErrorCode" type="xs:string" minOccurs="0"/>
                <xs:element name="ErrorMessage" type="xs:string" minOccurs="0"/>
                <xs:element name="ErrorDetail" type="xs:string" minOccurs="0" maxOccurs="unbounded" />
              </xs:sequence>
            </xs:complexType>
          </xs:element>

          <xs:annotation>
            <xs:documentation> Please refer to the associated Pro On Demand web service documentation for information about this feature.</xs:documentation>

          </xs:annotation>

          <xs:complexType name="VerificationFlagsType">
            <xs:sequence>
              <xs:element name="BldgFirmNameChanged" type="xs:boolean" default="false" minOccurs="0"/>
              <xs:element name="PrimaryNumberChanged" type="xs:boolean" default="false" minOccurs="0"/>
              <xs:element name="StreetCorrected" type="xs:boolean" default="false" minOccurs="0"/>
              <xs:element name="RuralRteHighwayContractMatched" type="xs:boolean" default="false" minOccurs="0"/>
              <xs:element name="CityNameChanged" type="xs:boolean" default="false" minOccurs="0"/>
              <xs:element name="CityAliasMatched" type="xs:boolean" default="false" minOccurs="0"/>
              <xs:element name="StateProvinceChanged" type="xs:boolean" default="false" minOccurs="0"/>
              <xs:element name="PostCodeCorrected" type="xs:boolean" default="false" minOccurs="0"/>
              <xs:element name="SecondaryNumRetained" type="xs:boolean" default="false" minOccurs="0"/>
              <xs:element name="IdenPreStInfoRetained" type="xs:boolean" default="false" minOccurs="0"/>
              <xs:element name="GenPreStInfoRetained" type="xs:boolean" default="false" minOccurs="0"/>
              <xs:element name="PostStInfoRetained" type="xs:boolean" default="false" minOccurs="0"/>
            </xs:sequence>
          </xs:complexType>

        </xs:schema>
      </types>

      <message name="QueryHeader">
        <part name="query_header" element="qas:QAQueryHeader"/>
      </message>

      <message name="QAInformation">
        <part name="information_header" element="qas:QAInformation"/>
      </message>

      <message name="Search">
        <part name="body" element="qas:QASearch" />
      </message>

      <message name="SearchResult">
        <part name="body" element="qas:QASearchResult" />
      </message>

      <message name="Refine">
        <part name="body" element="qas:QARefine" />
      </message>

      <message name="Picklist">
        <part name="body" element="qas:Picklist" />
      </message>

      <message name="GetAddress">
        <part name="body" element="qas:QAGetAddress" />
      </message>

      <message name="Address">
        <part name="body" element="qas:Address" />
      </message>

      <message name="GetData">
        <part name="body" element="qas:QAGetData" />
      </message>

      <message name="Data">
        <part name="body" element="qas:QAData" />
      </message>

      <message name="GetDataMapDetail">
        <part name="body" element="qas:QAGetDataMapDetail" />
      </message>

      <message name="DataMapDetail">
        <part name="body" element="qas:QADataMapDetail" />
      </message>

      <message name="GetLicenseInfo">
        <part name="body" element="qas:QAGetLicenseInfo" />
      </message>

      <message name="LicenseInfo">
        <part name="body" element="qas:QALicenceInfo" />
      </message>

      <message name="GetSystemInfo">
        <part name="body" element="qas:QAGetSystemInfo" />
      </message>

      <message name="SystemInfo">
        <part name="body" element="qas:QASystemInfo" />
      </message>

      <message name="GetExampleAddresses">
        <part name="body" element="qas:QAGetExampleAddresses" />
      </message>

      <message name="ExampleAddresses">
        <part name="body" element="qas:QAExampleAddresses" />
      </message>

      <message name="GetLayouts">
        <part name="body" element="qas:QAGetLayouts"/>
      </message>

      <message name="Layouts">
        <part name="body" element="qas:QALayouts"/>
      </message>

      <message name="GetPromptSet">
        <part name="body" element="qas:QAGetPromptSet"/>
      </message>

      <message name="PromptSet">
        <part name="body" element="qas:QAPromptSet"/>
      </message>

      <message name="CanSearch">
        <part name="body" element="qas:QACanSearch"/>
      </message>

      <message name="SearchOk">
        <part name="body" element="qas:QASearchOk"/>
      </message>

      <portType name="QAPortType">
        <operation name="DoSearch">
          <input message="qas:Search" />
          <output message="qas:SearchResult" />
        </operation>

        <operation name="DoRefine">
          <input message="qas:Refine" />
          <output message="qas:Picklist" />
        </operation>

        <operation name="DoGetAddress">
          <input message="qas:GetAddress" />
          <output message="qas:Address" />
        </operation>

        <operation name="DoGetData">
          <input message="qas:GetData" />
          <output message="qas:Data" />
        </operation>

        <operation name="DoGetDataMapDetail">
          <input message="qas:GetDataMapDetail" />
          <output message="qas:DataMapDetail" />
        </operation>

        <operation name="DoGetLicenseInfo">
          <input message="qas:GetLicenseInfo" />
          <output message="qas:LicenseInfo" />
        </operation>

        <operation name="DoGetSystemInfo">
          <input message="qas:GetSystemInfo"/>
          <output message="qas:SystemInfo"/>
        </operation>

        <operation name="DoGetExampleAddresses">
          <input message="qas:GetExampleAddresses"/>
          <output message="qas:ExampleAddresses"/>
        </operation>

        <operation name="DoGetLayouts">
          <input message="qas:GetLayouts"/>
          <output message="qas:Layouts"/>
        </operation>

        <operation name="DoGetPromptSet">
          <input message="qas:GetPromptSet"/>
          <output message="qas:PromptSet"/>
        </operation>

        <operation name="DoCanSearch">
          <input message="qas:CanSearch"/>
          <output message="qas:SearchOk"/>
        </operation>
      </portType>

      <binding name="QASOnDemand" type="qas:QAPortType">
        <soap:binding style="document" transport="http://schemas.xmlsoap.org/soap/http" />

        <operation name="DoSearch">
          <soap:operation soapAction="http://www.qas.com/OnDemand-2011-03/DoSearch" />
          <input>
            <soap:header message="qas:QueryHeader" part="query_header" use="literal"/>
            <soap:body use="literal" />
          </input>
          <output>
            <soap:header message="qas:QAInformation" part="information_header" use="literal"/>
            <soap:body use="literal" />
          </output>
        </operation>

        <operation name="DoRefine">
          <soap:operation soapAction="http://www.qas.com/OnDemand-2011-03/DoRefine" />
          <input>
            <soap:header message="qas:QueryHeader" part="query_header" use="literal"/>
            <soap:body use="literal" />
          </input>
          <output>
            <soap:header message="qas:QAInformation" part="information_header" use="literal"/>
            <soap:body use="literal" />
          </output>
        </operation>

        <operation name="DoGetAddress">
          <soap:operation soapAction="http://www.qas.com/OnDemand-2011-03/DoGetAddress" />
          <input>
            <soap:header message="qas:QueryHeader" part="query_header" use="literal"/>
            <soap:body use="literal" />
          </input>
          <output>
            <soap:header message="qas:QAInformation" part="information_header" use="literal"/>
            <soap:body use="literal" />
          </output>
        </operation>

        <operation name="DoGetData">
          <soap:operation soapAction="http://www.qas.com/OnDemand-2011-03/DoGetData" />
          <input>
            <soap:header message="qas:QueryHeader" part="query_header" use="literal"/>
            <soap:body use="literal" />
          </input>
          <output>
            <soap:header message="qas:QAInformation" part="information_header" use="literal"/>
            <soap:body use="literal" />
          </output>
        </operation>

        <operation name="DoGetDataMapDetail">
          <soap:operation soapAction="http://www.qas.com/OnDemand-2011-03/DoGetDataMapDetail" />
          <input>
            <soap:header message="qas:QueryHeader" part="query_header" use="literal"/>
            <soap:body use="literal" />
          </input>
          <output>
            <soap:header message="qas:QAInformation" part="information_header" use="literal"/>
            <soap:body use="literal" />
          </output>
        </operation>

        <operation name="DoGetLicenseInfo">
          <soap:operation soapAction="http://www.qas.com/OnDemand-2011-03/DoGetLicenseInfo" />
          <input>
            <soap:header message="qas:QueryHeader" part="query_header" use="literal"/>
            <soap:body use="literal" />
          </input>
          <output>
            <soap:header message="qas:QAInformation" part="information_header" use="literal"/>
            <soap:body use="literal" />
          </output>
        </operation>

        <operation name="DoGetSystemInfo">
          <soap:operation soapAction="http://www.qas.com/OnDemand-2011-03/DoGetSystemInfo" />
          <input>
            <soap:header message="qas:QueryHeader" part="query_header" use="literal"/>
            <soap:body use="literal" />
          </input>
          <output>
            <soap:header message="qas:QAInformation" part="information_header" use="literal"/>
            <soap:body use="literal" />
          </output>
        </operation>

        <operation name="DoGetExampleAddresses">
          <soap:operation soapAction="http://www.qas.com/OnDemand-2011-03/DoGetExampleAddresses" />
          <input>
            <soap:header message="qas:QueryHeader" part="query_header" use="literal"/>
            <soap:body use="literal" />
          </input>
          <output>
            <soap:header message="qas:QAInformation" part="information_header" use="literal"/>
            <soap:body use="literal" />
          </output>
        </operation>

        <operation name="DoGetLayouts">
          <soap:operation soapAction="http://www.qas.com/OnDemand-2011-03/DoGetLayouts" />
          <input>
            <soap:header message="qas:QueryHeader" part="query_header" use="literal"/>
            <soap:body use="literal" />
          </input>
          <output>
            <soap:header message="qas:QAInformation" part="information_header" use="literal"/>
            <soap:body use="literal" />
          </output>
        </operation>

        <operation name="DoGetPromptSet">
          <soap:operation soapAction="http://www.qas.com/OnDemand-2011-03/DoGetPromptSet" />
          <input>
            <soap:header message="qas:QueryHeader" part="query_header" use="literal"/>
            <soap:body use="literal" />
          </input>
          <output>
            <soap:header message="qas:QAInformation" part="information_header" use="literal"/>
            <soap:body use="literal" />
          </output>
        </operation>

        <operation name="DoCanSearch">
          <soap:operation soapAction="http://www.qas.com/OnDemand-2011-03/DoCanSearch" />
          <input>
            <soap:header message="qas:QueryHeader" part="query_header" use="literal"/>
            <soap:body use="literal" />
          </input>
          <output>
            <soap:header message="qas:QAInformation" part="information_header" use="literal"/>
            <soap:body use="literal" />
          </output>
        </operation>
      </binding>

      <service name="QASOnDemandIntermediary">
        <port binding="qas:QASOnDemand" name="QAPortType">
          <soap:address location="https://ws2.ondemand.qas.com/ProOnDemand/V3/ProOnDemandService.asmx" />
        </port>
      </service>
    </definitions>
